<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'price',
        'duration',
        'unit',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (! $service->slug) {
                $service->slug = Str::slug($service->name);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('name') && ! $service->isDirty('slug')) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    /**
     * Get the transactions for the service.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
