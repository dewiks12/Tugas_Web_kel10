<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            ],
            [
                'name' => 'Express Wash & Iron',
                'description' => 'Express laundry service with washing and ironing, same day completion.',
                'price' => 25000,
            ],
            [
                'name' => 'Dry Clean',
                'description' => 'Professional dry cleaning service for delicate garments.',
                'price' => 35000,
            ],
            [
                'name' => 'Ironing Only',
                'description' => 'Ironing service for pre-washed clothes.',
                'price' => 10000,
            ],
            [
                'name' => 'Bedding & Linen',
                'description' => 'Special service for bedding items and household linen.',
                'price' => 30000,
            ],
            [
                'name' => 'Shoes & Sneakers',
                'description' => 'Professional cleaning service for shoes and sneakers.',
                'price' => 45000,
            ],
            [
                'name' => 'Bag & Leather',
                'description' => 'Specialized cleaning service for bags and leather items.',
                'price' => 50000,
            ],
            [
                'name' => 'Carpet & Rug',
                'description' => 'Deep cleaning service for carpets and rugs.',
                'price' => 75000,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
