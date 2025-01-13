<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Main Branch',
            'code' => 'MAIN',
            'address' => 'Main Street 123',
            'phone' => '123456789',
            'is_active' => true,
        ]);
    }
}
