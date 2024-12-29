<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with(['role', 'branch']);

        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);
        $roles = Role::all();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.users.index', compact('users', 'roles', 'branches'));
    }

    public function create()
    {
        $roles = Role::all();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.users.form', compact('roles', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'telegram_id' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'telegram_id' => $request->telegram_id,
            'whatsapp' => $request->whatsapp,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.users.form', compact('user', 'roles', 'branches'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'telegram_id' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'telegram_id' => $request->telegram_id,
            'whatsapp' => $request->whatsapp,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin() && User::whereHas('role', function($query) {
            $query->where('slug', 'admin');
        })->count() === 1) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
