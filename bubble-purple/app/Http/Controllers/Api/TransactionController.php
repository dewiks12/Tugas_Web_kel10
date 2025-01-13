<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['customer', 'branch', 'transactionServices.service'])
            ->where('customer_id', $request->user()->id)
            ->latest()
            ->get();
        
        return response()->json([
            'transactions' => $transactions
        ]);
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->customer_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'transaction' => $transaction->load(['customer', 'branch', 'transactionServices.service'])
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
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
                'customer_id' => $request->user()->id,
                'branch_id' => $request->branch_id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $request->notes,
                'payment_status' => 'pending',
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

            return response()->json([
                'message' => 'Transaction created successfully',
                'transaction' => $transaction->load(['customer', 'branch', 'transactionServices.service'])
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 