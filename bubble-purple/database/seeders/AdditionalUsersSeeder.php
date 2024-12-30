<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdditionalUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Get role IDs
        $adminRole = Role::where('name', 'admin')->first();
        $employeeRole = Role::where('name', 'employee')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Get main branch
        $mainBranch = Branch::first();

        // Create admin user
        User::create([
            'name' => 'Tasya',
            'email' => 'tasya@gmail.com',
            'password' => Hash::make('12341234'),
            'role_id' => $adminRole->id,
            'branch_id' => $mainBranch->id,
            'is_active' => true,
        ]);

        // Create employee user
        User::create([
            'name' => 'Melani',
            'email' => 'melani@gmail.com', 
            'password' => Hash::make('12341234'),
            'role_id' => $employeeRole->id,
            'branch_id' => $mainBranch->id,
            'is_active' => true,
        ]);

        // Create customer user
        User::create([
            'name' => 'Dewi',
            'email' => 'dewi@gmail.com',
            'password' => Hash::make('12341234'),
            'role_id' => $customerRole->id,
            'branch_id' => $mainBranch->id,
            'is_active' => true,
        ]);
    }
} 