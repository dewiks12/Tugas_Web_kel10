<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'branch'])
            ->where('branch_id', auth()->user()->branch_id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(10);

        return view('employee.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = Customer::where('branch_id', auth()->user()->branch_id)
            ->where('is_active', true)
            ->get();
        $services = Service::where('is_active', true)->get();

        return view('employee.transactions.form', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'services' => 'required|array|min:1',
            'services.*' => 'required|exists:services,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|numeric|min:0.01',
            'prices' => 'required|array|min:1',
            'prices.*' => 'required|numeric|min:0',
            'subtotals' => 'required|array|min:1',
            'subtotals.*' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'pickup_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
                'user_id' => auth()->id(),
                'branch_id' => auth()->user()->branch_id,
                'customer_id' => $request->customer_id,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'pickup_date' => $request->pickup_date,
                'notes' => $request->notes,
            ]);

            foreach ($request->services as $index => $serviceId) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'service_id' => $serviceId,
                    'quantity' => $request->quantities[$index],
                    'price' => $request->prices[$index],
                    'subtotal' => $request->subtotals[$index],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('employee.transactions.show', $transaction)
                ->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create transaction. Please try again.');
        }
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        $transaction->load(['customer', 'branch', 'items.service']);

        return view('employee.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Only pending transactions can be edited.');
        }

        $transaction->load(['customer', 'branch', 'items.service']);
        $customers = Customer::where('branch_id', auth()->user()->branch_id)
            ->where('is_active', true)
            ->get();
        $services = Service::where('is_active', true)->get();

        return view('employee.transactions.form', compact('transaction', 'customers', 'services'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Only pending transactions can be updated.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'services' => 'required|array|min:1',
            'services.*' => 'required|exists:services,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|numeric|min:0.01',
            'prices' => 'required|array|min:1',
            'prices.*' => 'required|numeric|min:0',
            'subtotals' => 'required|array|min:1',
            'subtotals.*' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'pickup_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $transaction->update([
                'customer_id' => $request->customer_id,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'pickup_date' => $request->pickup_date,
                'notes' => $request->notes,
            ]);

            // Delete existing items
            $transaction->items()->delete();

            // Create new items
            foreach ($request->services as $index => $serviceId) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'service_id' => $serviceId,
                    'quantity' => $request->quantities[$index],
                    'price' => $request->prices[$index],
                    'subtotal' => $request->subtotals[$index],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('employee.transactions.show', $transaction)
                ->with('success', 'Transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update transaction. Please try again.');
        }
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Only pending transactions can be deleted.');
        }

        try {
            DB::beginTransaction();

            // Delete transaction items
            $transaction->items()->delete();

            // Delete transaction
            $transaction->delete();

            DB::commit();

            return redirect()
                ->route('employee.transactions.index')
                ->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete transaction. Please try again.');
        }
    }
}
