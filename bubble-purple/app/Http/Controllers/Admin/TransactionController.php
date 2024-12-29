<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'branch', 'user']);

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply branch filter
        if ($request->has('branch') && $request->get('branch') !== '') {
            $query->where('branch_id', $request->get('branch'));
        }

        // Apply status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('status', $request->get('status'));
        }

        // Get paginated results
        $transactions = $query->latest()->paginate(10);
        $branches = Branch::where('is_active', true)->get();

        return view('admin.transactions.index', compact('transactions', 'branches'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $customers = User::whereHas('role', function ($query) {
            $query->where('slug', 'customer');
        })->get();
        $branches = Branch::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();

        return view('admin.transactions.form', compact('customers', 'branches', 'services'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:users,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'exists:services,id'],
            'quantities' => ['required', 'array', 'min:1'],
            'quantities.*' => ['required', 'numeric', 'min:0.01'],
            'prices' => ['required', 'array', 'min:1'],
            'prices.*' => ['required', 'numeric', 'min:0'],
            'subtotals' => ['required', 'array', 'min:1'],
            'subtotals.*' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
            'pickup_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        try {
            DB::beginTransaction();

            // Create transaction
            $transaction = Transaction::create([
                'invoice_number' => 'INV' . date('YmdHis'),
                'user_id' => auth()->id(),
                'customer_id' => $validated['customer_id'],
                'branch_id' => $validated['branch_id'],
                'total_amount' => $validated['total_amount'],
                'status' => $validated['status'],
                'pickup_date' => $validated['pickup_date'],
                'notes' => $validated['notes'],
            ]);

            // Create transaction items
            foreach ($validated['services'] as $index => $serviceId) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'service_id' => $serviceId,
                    'quantity' => $validated['quantities'][$index],
                    'price' => $validated['prices'][$index],
                    'subtotal' => $validated['subtotals'][$index],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.transactions.show', $transaction)
                ->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create transaction. Please try again.');
        }
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'branch', 'user', 'items.service']);

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load(['items.service']);
        $customers = User::whereHas('role', function ($query) {
            $query->where('slug', 'customer');
        })->get();
        $branches = Branch::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();

        return view('admin.transactions.form', compact('transaction', 'customers', 'branches', 'services'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:users,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'exists:services,id'],
            'quantities' => ['required', 'array', 'min:1'],
            'quantities.*' => ['required', 'numeric', 'min:0.01'],
            'prices' => ['required', 'array', 'min:1'],
            'prices.*' => ['required', 'numeric', 'min:0'],
            'subtotals' => ['required', 'array', 'min:1'],
            'subtotals.*' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
            'pickup_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        try {
            DB::beginTransaction();

            // Update transaction
            $transaction->update([
                'customer_id' => $validated['customer_id'],
                'branch_id' => $validated['branch_id'],
                'total_amount' => $validated['total_amount'],
                'status' => $validated['status'],
                'pickup_date' => $validated['pickup_date'],
                'notes' => $validated['notes'],
            ]);

            // Delete old items
            $transaction->items()->delete();

            // Create new items
            foreach ($validated['services'] as $index => $serviceId) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'service_id' => $serviceId,
                    'quantity' => $validated['quantities'][$index],
                    'price' => $validated['prices'][$index],
                    'subtotal' => $validated['subtotals'][$index],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.transactions.show', $transaction)
                ->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update transaction. Please try again.');
        }
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->items()->delete();
        $transaction->delete();

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
