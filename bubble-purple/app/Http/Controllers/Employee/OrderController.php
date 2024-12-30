<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $customers = Customer::where('branch_id', Auth::user()->branch_id)->get();
        
        return view('employee.orders.create', compact('services', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $services = Service::whereIn('id', collect($request->services)->pluck('id'))->get();
        
        $totalAmount = 0;
        foreach ($request->services as $serviceData) {
            $service = $services->firstWhere('id', $serviceData['id']);
            $totalAmount += $service->price * $serviceData['quantity'];
        }

        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'branch_id' => Auth::user()->branch_id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($request->services as $serviceData) {
            $service = $services->firstWhere('id', $serviceData['id']);
            $transaction->services()->attach($service->id, [
                'quantity' => $serviceData['quantity'],
                'price' => $service->price,
                'subtotal' => $service->price * $serviceData['quantity'],
            ]);
        }

        return redirect()->route('employee.transactions.show', $transaction)
            ->with('success', 'Order created successfully.');
    }
} 