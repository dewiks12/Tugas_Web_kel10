<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Main Branch',
            'slug' => 'main-branch',
            'code' => 'MB001',
            'address' => 'Jl. Raya Utama No. 1',
            'phone' => '021-1234567',
            'is_active' => true,
        ]);
    }
}
