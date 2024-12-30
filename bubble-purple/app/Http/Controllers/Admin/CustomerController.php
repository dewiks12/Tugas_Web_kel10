<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $customerRole = Role::where('name', 'customer')->first();
            if (!$customerRole) {
                throw new \Exception('Customer role not found');
            }

            $customer = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'role_id' => $customerRole->id,
                'is_active' => true,
            ]);

            DB::commit();

            Log::info('Customer created successfully', ['customer_id' => $customer->id]);
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create customer', ['error' => $e->getMessage()]);
            return back()->withInput()
                ->with('error', 'Failed to create customer. ' . $e->getMessage());
        }
    }

    public function edit(User $customer)
    {
        if ($customer->role->name !== 'customer') {
            abort(404);
        }
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->role->name !== 'customer') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => $request->is_active,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $customer->update($updateData);

            DB::commit();

            Log::info('Customer updated successfully', ['customer_id' => $customer->id]);
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update customer', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()
                ->with('error', 'Failed to update customer. ' . $e->getMessage());
        }
    }

    public function destroy(User $customer)
    {
        if ($customer->role->name !== 'customer') {
            abort(404);
        }

        try {
            DB::beginTransaction();

            // Check if customer has any transactions
            if ($customer->transactions()->exists()) {
                // Soft delete by deactivating
                $customer->update(['is_active' => false]);
            } else {
                // Hard delete if no transactions
                $customer->delete();
            }

            DB::commit();

            Log::info('Customer deleted successfully', ['customer_id' => $customer->id]);
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete customer', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to delete customer. ' . $e->getMessage());
        }
    }
} 