<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $employeeRole = Role::where('name', 'employee')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Get main branch
        $mainBranch = Branch::where('code', 'MAIN')->first();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'tasya@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);

        // Create employee user
        User::create([
            'name' => 'Employee User',
            'email' => 'melani@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $employeeRole->id,
            'branch_id' => $mainBranch->id,
            'is_active' => true,
        ]);

        // Create customer user
        User::create([
            'name' => 'Customer User',
            'email' => 'dewi@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $customerRole->id,
            'is_active' => true,
        ]);
    }
}
