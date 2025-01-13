<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Cuci_Basah',
            'description' => 'Layanan cuci basah standar',
            'price' => 7000,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Premium_Wash',
            'description' => 'Layanan cuci premium dengan deterjen khusus',
            'price' => 12000,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Setrika',
            'description' => 'Layanan setrika profesional',
            'price' => 5000,
            'is_active' => true,
        ]);
    }
}
