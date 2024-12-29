<?php

namespace App\Models;

use App\Notifications\TransactionStatusChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'user_id',
        'branch_id',
        'customer_id',
        'total_amount',
        'status',
        'pickup_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'pickup_date' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::updating(function ($transaction) {
            // If status is changed, notify the customer
            if ($transaction->isDirty('status')) {
                $oldStatus = $transaction->getOriginal('status');
                $transaction->customer->notify(new TransactionStatusChanged($transaction, $oldStatus));
            }
        });
    }

    /**
     * Get the user who created the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the branch associated with the transaction.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the customer associated with the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the items for the transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Get the services for the transaction.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'transaction_items')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    /**
     * Get the status color for badges.
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Calculate total amount based on items.
     */
    public function calculateTotal()
    {
        $this->total_amount = $this->items->sum('subtotal');
        $this->save();
    }

    /**
     * Update transaction status.
     */
    public function updateStatus(string $status)
    {
        if (in_array($status, ['pending', 'processing', 'completed', 'cancelled'])) {
            $this->status = $status;
            $this->save();
            return true;
        }
        return false;
    }
}
