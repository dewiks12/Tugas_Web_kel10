<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\LaundryTarget;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LaundryTargetSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();
        $now = Carbon::now();

        foreach ($branches as $branch) {
            LaundryTarget::create([
                'branch_id' => $branch->id,
                'month' => $now->month,
                'year' => $now->year,
                'target_amount' => 50000000, // 50 million
                'achieved_amount' => 0,
                'is_achieved' => false,
            ]);
        }
    }
} 