<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'System administrator with full access to all features.',
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Branch employee with access to customer and transaction management.',
            ],
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Customer with access to their own transactions.',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
