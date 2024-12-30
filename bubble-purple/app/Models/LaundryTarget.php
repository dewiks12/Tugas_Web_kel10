<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaundryTarget extends Model
{
    protected $fillable = [
        'branch_id',
        'month',
        'year',
        'target_amount',
        'achieved_amount',
        'is_achieved',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'achieved_amount' => 'decimal:2',
        'is_achieved' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
