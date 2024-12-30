<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Bubble Purple - Main Branch',
                'slug' => 'main-branch',
                'code' => 'MB001',
                'address' => 'Jl. Raya Utama No. 123, Jakarta Selatan',
                'phone' => '021-1234567',
                'is_active' => true,
            ],
            [
                'name' => 'Bubble Purple - Kemang',
                'slug' => 'kemang-branch',
                'code' => 'KB001',
                'address' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
                'phone' => '021-7654321',
                'is_active' => true,
            ],
            [
                'name' => 'Bubble Purple - Kelapa Gading',
                'slug' => 'kelapa-gading-branch',
                'code' => 'KG001',
                'address' => 'Jl. Boulevard Raya No. 88, Jakarta Utara',
                'phone' => '021-8765432',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
