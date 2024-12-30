<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use App\Models\Role;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create main branch
        $branch = Branch::create([
            'name' => 'Main Branch',
            'slug' => 'main-branch',
            'code' => 'MB001',
            'address' => 'Jl. Main Street No. 1',
            'phone' => '08123456789',
            'is_active' => true,
        ]);

        // Create admin user
        User::create([
            'name' => 'Tasya',
            'email' => 'tasya@gmail.com',
            'password' => bcrypt('12341234'),
            'role_id' => Role::where('name', 'admin')->first()->id,
            'branch_id' => $branch->id,
            'is_active' => true,
        ]);

        // Create employee user
        User::create([
            'name' => 'Melani',
            'email' => 'melani@gmail.com',
            'password' => bcrypt('12341234'),
            'role_id' => Role::where('name', 'employee')->first()->id,
            'branch_id' => $branch->id,
            'is_active' => true,
        ]);

        // Create customer user
        User::create([
            'name' => 'Dewi',
            'email' => 'dewi@gmail.com',
            'password' => bcrypt('12341234'),
            'role_id' => Role::where('name', 'customer')->first()->id,
            'branch_id' => $branch->id,
            'phone' => '08123456789',
            'address' => 'Jl. Customer Street No. 1',
            'whatsapp' => '08123456789',
            'is_active' => true,
        ]);

        // Create default services
        Service::create([
            'name' => 'Regular Wash',
            'description' => 'Regular washing service with standard detergent',
            'price' => 7000,
            'unit' => 'kg',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Express Wash',
            'description' => 'Express washing service with premium detergent (24 hours)',
            'price' => 12000,
            'unit' => 'kg',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Dry Clean',
            'description' => 'Professional dry cleaning service',
            'price' => 15000,
            'unit' => 'pcs',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Ironing Only',
            'description' => 'Professional ironing service',
            'price' => 5000,
            'unit' => 'pcs',
            'is_active' => true,
        ]);
    }
}
