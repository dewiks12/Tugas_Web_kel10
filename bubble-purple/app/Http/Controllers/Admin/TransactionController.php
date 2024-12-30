<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['customer', 'branch', 'transactionServices.service'])
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'branch', 'transactionServices.service']);
        return view('admin.transactions.show', compact('transaction'));
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

    public function getCurrencyRates()
    {
        $response = Http::get('https://open.er-api.com/v6/latest/IDR');
        return response()->json($response->json());
    }

    public function getWeather()
    {
        $response = Http::get('https://goweather.herokuapp.com/weather/Jakarta');
        return response()->json($response->json());
    }
}
