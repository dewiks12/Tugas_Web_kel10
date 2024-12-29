<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that belong to this branch.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the customers that belong to this branch.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the transactions that belong to this branch.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
