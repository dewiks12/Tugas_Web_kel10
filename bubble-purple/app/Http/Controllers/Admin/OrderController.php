<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        $customers = User::whereHas('role', function($query) {
            $query->where('slug', 'customer');
        })->where('is_active', true)->get();

        $services = Service::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('admin.orders.create', compact('customers', 'services', 'branches'));
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

            return redirect()->route('admin.transactions.show', $transaction)
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order. Please try again.');
        }
    }
} 