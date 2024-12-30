<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'slug' => 'admin'
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee',
                'slug' => 'employee'
            ],
            [
                'name' => 'customer',
                'display_name' => 'Customer',
                'slug' => 'customer'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                [
                    'display_name' => $role['display_name'],
                    'slug' => $role['slug']
                ]
            );
        }
    }
}
