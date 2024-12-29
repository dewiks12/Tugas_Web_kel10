<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'address' => 'Jl. Raya Utama No. 123, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'Bubble Purple - Kemang',
                'address' => 'Jl. Kemang Raya No. 45, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'Bubble Purple - Kelapa Gading',
                'address' => 'Jl. Boulevard Raya No. 88, Jakarta Utara',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
