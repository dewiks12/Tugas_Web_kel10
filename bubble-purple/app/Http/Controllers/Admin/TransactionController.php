<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'branch', 'transactionServices.service']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(10);
        $branches = Branch::where('is_active', true)->get();

        return view('admin.transactions.index', compact('transactions', 'branches'));
    }

    public function create()
    {
        $customers = User::whereHas('role', function($query) {
            $query->where('name', 'customer');
        })->where('is_active', true)->get();

        $services = Service::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.transactions.create', compact('customers', 'services', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->services as $service) {
                $serviceModel = Service::find($service['id']);
                $totalAmount += $serviceModel->price * $service['quantity'];
            }

            // Create transaction
            $transaction = Transaction::create([
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Attach services
            foreach ($request->services as $service) {
                $transaction->transactionServices()->create([
                    'service_id' => $service['id'],
                    'quantity' => $service['quantity'],
                    'price' => Service::find($service['id'])->price,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.transactions.show', $transaction)
                ->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create transaction. ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'branch', 'transactionServices.service']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->status === 'completed' || $transaction->status === 'cancelled') {
            return redirect()->route('admin.transactions.show', $transaction)
                ->with('error', 'Cannot edit completed or cancelled transactions.');
        }

        $transaction->load(['customer', 'branch', 'transactionServices.service']);
        
        $customers = User::whereHas('role', function($query) {
            $query->where('name', 'customer');
        })->where('is_active', true)->get();

        $services = Service::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.transactions.edit', compact('transaction', 'customers', 'services', 'branches'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->status === 'completed' || $transaction->status === 'cancelled') {
            return redirect()->route('admin.transactions.show', $transaction)
                ->with('error', 'Cannot update completed or cancelled transactions.');
        }

        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->services as $service) {
                $serviceModel = Service::find($service['id']);
                $totalAmount += $serviceModel->price * $service['quantity'];
            }

            // Update transaction
            $transaction->update([
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            // Sync services
            $transaction->transactionServices()->delete();
            foreach ($request->services as $service) {
                $transaction->transactionServices()->create([
                    'service_id' => $service['id'],
                    'quantity' => $service['quantity'],
                    'price' => Service::find($service['id'])->price,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.transactions.show', $transaction)
                ->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update transaction. ' . $e->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            // Delete transaction services first
            $transaction->transactionServices()->delete();
            
            // Then delete the transaction
            $transaction->delete();

            DB::commit();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete transaction. ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $transaction->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }
}
