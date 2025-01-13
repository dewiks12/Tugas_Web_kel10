<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function employees()
    {
        return $this->hasMany(User::class)->whereHas('role', function($query) {
            $query->where('name', 'employee');
        });
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
