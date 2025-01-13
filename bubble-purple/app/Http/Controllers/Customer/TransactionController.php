<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('customer_id', auth()->id())
            ->with(['transactionServices.service', 'branch'])
            ->latest()
            ->paginate(10);

        return view('customer.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        // Ensure customer can only view their own transactions
        if ($transaction->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->load(['transactionServices.service', 'branch']);
        return view('customer.transactions.show', compact('transaction'));
    }
}
