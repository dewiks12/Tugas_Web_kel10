<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Wash & Fold',
                'code' => 'WF001',
                'description' => 'Regular laundry service - wash, dry, and fold',
                'price' => 15000.00,
                'duration' => 2,
                'unit' => 'kg',
            ],
            [
                'name' => 'Dry Cleaning',
                'code' => 'DC001',
                'description' => 'Professional dry cleaning service for delicate garments',
                'price' => 25000.00,
                'duration' => 3,
                'unit' => 'piece',
            ],
            [
                'name' => 'Ironing & Pressing',
                'code' => 'IP001',
                'description' => 'Professional ironing and pressing service',
                'price' => 10000.00,
                'duration' => 1,
                'unit' => 'piece',
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'code' => $service['code'],
                'description' => $service['description'],
                'price' => $service['price'],
                'duration' => $service['duration'],
                'unit' => $service['unit'],
                'is_active' => true,
            ]);
        }
    }
}
