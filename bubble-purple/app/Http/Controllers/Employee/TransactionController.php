<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        $branch = auth()->user()->branch;
        $transactions = Transaction::where('branch_id', $branch->id)
            ->with(['customer', 'transactionServices.service'])
            ->latest()
            ->paginate(10);

        return view('employee.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        // Ensure employee can only view transactions from their branch
        if ($transaction->branch_id !== auth()->user()->branch->id) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->load(['customer', 'transactionServices.service', 'branch']);
        return view('employee.transactions.show', compact('transaction'));
    }

    public function updateStatus(Transaction $transaction, Request $request)
    {
        // Validate employee can only update transactions from their branch
        if ($transaction->branch_id !== auth()->user()->branch->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        try {
            $oldStatus = $transaction->status;
            $transaction->update([
                'status' => $request->status
            ]);

            Log::info('Transaction status updated', [
                'transaction_id' => $transaction->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'updated_by' => auth()->id()
            ]);

            return back()->with('success', 'Transaction status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update transaction status', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id,
                'status' => $request->status
            ]);
            return back()->with('error', 'Failed to update transaction status.');
        }
    }
}
