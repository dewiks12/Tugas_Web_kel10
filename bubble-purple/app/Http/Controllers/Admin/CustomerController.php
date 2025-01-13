<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::whereHas('role', function($query) {
            $query->where('name', 'customer');
        })->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:20',
            'telegram_id' => 'nullable|string|max:255',
        ]);

        // Get customer role
        $customerRole = Role::where('name', 'customer')->first();

        // Create user with customer role
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'), // Default password
            'phone' => $request->phone,
            'address' => $request->address,
            'whatsapp' => $request->whatsapp,
            'telegram_id' => $request->telegram_id,
            'role_id' => $customerRole->id,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully. Default password is: password');
    }

    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:20',
            'telegram_id' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'whatsapp' => $request->whatsapp,
            'telegram_id' => $request->telegram_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }
} 