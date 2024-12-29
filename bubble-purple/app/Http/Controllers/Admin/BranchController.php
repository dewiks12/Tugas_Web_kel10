<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    /**
     * Display a listing of the branches.
     */
    public function index(Request $request)
    {
        $query = Branch::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status'));
        }

        // Get paginated results
        $branches = $query->latest()->paginate(10);

        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     */
    public function create()
    {
        return view('admin.branches.form');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:branches'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'is_active' => ['boolean'],
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        Branch::create($validated);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    /**
     * Show the form for editing the specified branch.
     */
    public function edit(Branch $branch)
    {
        return view('admin.branches.form', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:branches,code,' . $branch->id],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'is_active' => ['boolean'],
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = Str::slug($validated['name']);

        $branch->update($validated);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}
