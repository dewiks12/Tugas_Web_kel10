<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'service_id',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the transaction that owns the item.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the service associated with the item.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
