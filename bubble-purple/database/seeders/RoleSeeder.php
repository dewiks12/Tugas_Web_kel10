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
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee',
            ],
            [
                'name' => 'customer',
                'display_name' => 'Customer',
            ],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'slug' => Str::slug($role['name']),
            ]);
        }
    }
}
