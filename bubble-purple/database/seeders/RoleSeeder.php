<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrator']);
        Role::create(['name' => 'employee', 'description' => 'Employee']);
        Role::create(['name' => 'customer', 'description' => 'Customer']);
    }
}
