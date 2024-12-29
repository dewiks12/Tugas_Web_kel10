<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryTarget extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'target_amount',
        'achieved_amount',
        'target_orders',
        'achieved_orders',
        'start_date',
        'end_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'target_amount' => 'decimal:2',
        'achieved_amount' => 'decimal:2',
        'target_orders' => 'integer',
        'achieved_orders' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the branch that owns the target.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Calculate progress percentage for amount.
     */
    public function getAmountProgressAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(100, round(($this->achieved_amount / $this->target_amount) * 100, 2));
    }

    /**
     * Calculate progress percentage for orders.
     */
    public function getOrdersProgressAttribute()
    {
        if ($this->target_orders <= 0) {
            return 0;
        }
        return min(100, round(($this->achieved_orders / $this->target_orders) * 100, 2));
    }

    /**
     * Check if target is achieved.
     */
    public function getIsAchievedAttribute()
    {
        return $this->amount_progress >= 100 && $this->orders_progress >= 100;
    }

    /**
     * Check if target is active.
     */
    public function getIsActiveAttribute()
    {
        $now = now()->startOfDay();
        return $now->between($this->start_date, $this->end_date);
    }
}
