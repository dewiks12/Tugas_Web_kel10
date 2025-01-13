<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'is_active' => 'required|boolean'
        ]);

        try {
            DB::beginTransaction();

            $branch = Branch::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'is_active' => $request->is_active
            ]);

            DB::commit();

            Log::info('Branch created successfully', ['branch_id' => $branch->id]);
            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create branch', ['error' => $e->getMessage()]);
            return back()->withInput()
                ->with('error', 'Failed to create branch. ' . $e->getMessage());
        }
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'is_active' => 'required|boolean'
        ]);

        try {
            DB::beginTransaction();

            $branch->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'is_active' => $request->is_active
            ]);

            DB::commit();

            Log::info('Branch updated successfully', ['branch_id' => $branch->id]);
            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update branch', [
                'branch_id' => $branch->id,
                'error' => $e->getMessage()
            ]);
            return back()->withInput()
                ->with('error', 'Failed to update branch. ' . $e->getMessage());
        }
    }

    public function destroy(Branch $branch)
    {
        try {
            DB::beginTransaction();

            // Check if branch has any transactions
            if ($branch->transactions()->exists()) {
                // Soft delete by deactivating
                $branch->update(['is_active' => false]);
            } else {
                // Hard delete if no transactions
                $branch->delete();
            }

            DB::commit();

            Log::info('Branch deleted successfully', ['branch_id' => $branch->id]);
            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete branch', [
                'branch_id' => $branch->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Failed to delete branch. ' . $e->getMessage());
        }
    }
}
