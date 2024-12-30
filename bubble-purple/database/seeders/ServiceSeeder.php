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
                'name' => 'Regular Wash & Iron',
                'description' => 'Regular laundry service with washing and ironing, 2-3 days completion time.',
                'price' => 15000,
                'code' => 'RWI001',
                'duration' => 60,
                'unit' => 'kg',
            ],
            [
                'name' => 'Express Wash & Iron',
                'description' => 'Express laundry service with washing and ironing, same day completion.',
                'price' => 25000,
                'code' => 'EWI001',
                'duration' => 30,
                'unit' => 'kg',
            ],
            [
                'name' => 'Dry Clean',
                'description' => 'Professional dry cleaning service for delicate garments.',
                'price' => 35000,
                'code' => 'DRY001',
                'duration' => 120,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Ironing Only',
                'description' => 'Ironing service for pre-washed clothes.',
                'price' => 10000,
                'code' => 'IRO001',
                'duration' => 30,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Bedding & Linen',
                'description' => 'Special service for bedding items and household linen.',
                'price' => 30000,
                'code' => 'BED001',
                'duration' => 90,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Shoes & Sneakers',
                'description' => 'Professional cleaning service for shoes and sneakers.',
                'price' => 45000,
                'code' => 'SHO001',
                'duration' => 120,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Bag & Leather',
                'description' => 'Specialized cleaning service for bags and leather items.',
                'price' => 50000,
                'code' => 'BAG001',
                'duration' => 180,
                'unit' => 'pcs',
            ],
            [
                'name' => 'Carpet & Rug',
                'description' => 'Deep cleaning service for carpets and rugs.',
                'price' => 75000,
                'code' => 'CAR001',
                'duration' => 240,
                'unit' => 'pcs',
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
