<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'branch_id',
        'total_amount',
        'status',
        'notes',
        'payment_method',
        'payment_status',
        'payment_proof',
        'payment_date',
        'created_by',
        'invoice_number',
        'pickup_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'pickup_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function transactionServices()
    {
        return $this->hasMany(TransactionService::class);
    }

    // Alias for transactionServices for backward compatibility
    public function items()
    {
        return $this->transactionServices();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Status color accessor
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'completed' => 'green',
            'processing' => 'blue',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    // Status label accessor
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    // Generate invoice number
    public static function generateInvoiceNumber()
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
    }
}
