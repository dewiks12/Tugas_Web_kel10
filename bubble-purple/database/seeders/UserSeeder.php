<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $employeeRole = Role::where('slug', 'employee')->first();

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'branch_id' => 1, // Main Branch
            'is_active' => true,
        ]);

        // Create employee users
        $employees = [
            [
                'name' => 'Employee Kemang',
                'email' => 'employee.kemang@example.com',
                'branch_id' => 2, // Kemang Branch
            ],
            [
                'name' => 'Employee Kelapa Gading',
                'email' => 'employee.kelapagading@example.com',
                'branch_id' => 3, // Kelapa Gading Branch
            ],
        ];

        foreach ($employees as $employee) {
            User::create([
                'name' => $employee['name'],
                'email' => $employee['email'],
                'password' => Hash::make('password'),
                'role_id' => $employeeRole->id,
                'branch_id' => $employee['branch_id'],
                'is_active' => true,
            ]);
        }
    }
}
