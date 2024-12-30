<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create()
    {
        $branch = auth()->user()->branch;
        
        $customers = User::whereHas('role', function($query) {
            $query->where('name', 'customer');
        })->where('is_active', true)->get();

        $services = Service::where('is_active', true)->get();

        return view('employee.orders.create', compact('customers', 'services', 'branch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Debug: Log the request data
            Log::info('Creating new order with data:', [
                'customer_id' => $request->customer_id,
                'services' => $request->services,
                'notes' => $request->notes
            ]);

            $branch = auth()->user()->branch;
            $customer = User::findOrFail($request->customer_id);

            // Debug: Log customer and branch info
            Log::info('Customer and branch info:', [
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'role' => $customer->role->name
                ],
                'branch' => [
                    'id' => $branch->id,
                    'name' => $branch->name
                ]
            ]);

            // Verify customer has customer role
            if (!$customer->hasRole('customer')) {
                throw new \Exception('Invalid customer selected.');
            }

            // Calculate total amount
            $totalAmount = 0;
            $serviceDetails = [];
            foreach ($request->services as $service) {
                $serviceModel = Service::findOrFail($service['id']);
                $totalAmount += $serviceModel->price * $service['quantity'];
                $serviceDetails[] = [
                    'id' => $serviceModel->id,
                    'name' => $serviceModel->name,
                    'price' => $serviceModel->price,
                    'quantity' => $service['quantity']
                ];
            }

            // Debug: Log service details
            Log::info('Service details:', [
                'services' => $serviceDetails,
                'total_amount' => $totalAmount
            ]);

            // Create transaction
            $transaction = Transaction::create([
                'customer_id' => $customer->id,
                'branch_id' => $branch->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $request->notes,
                'payment_status' => 'unpaid',
                'created_by' => auth()->id(),
                'invoice_number' => Transaction::generateInvoiceNumber()
            ]);

            // Debug: Log transaction creation
            Log::info('Transaction created:', [
                'transaction_id' => $transaction->id,
                'invoice_number' => $transaction->invoice_number,
                'customer_id' => $transaction->customer_id,
                'branch_id' => $transaction->branch_id,
                'total_amount' => $transaction->total_amount,
                'status' => $transaction->status
            ]);

            // Attach services
            foreach ($request->services as $service) {
                $serviceModel = Service::findOrFail($service['id']);
                $transactionService = $transaction->transactionServices()->create([
                    'service_id' => $service['id'],
                    'quantity' => $service['quantity'],
                    'price' => $serviceModel->price,
                    'subtotal' => $serviceModel->price * $service['quantity'],
                ]);

                // Debug: Log service attachment
                Log::info('Service attached to transaction:', [
                    'transaction_id' => $transaction->id,
                    'service_id' => $transactionService->service_id,
                    'quantity' => $transactionService->quantity,
                    'price' => $transactionService->price,
                    'subtotal' => $transactionService->subtotal
                ]);
            }

            DB::commit();

            // Verify the transaction was created
            $verifyTransaction = Transaction::with(['customer', 'transactionServices.service'])
                ->findOrFail($transaction->id);

            // Debug: Log verification
            Log::info('Transaction verification:', [
                'transaction_exists' => $verifyTransaction ? true : false,
                'services_count' => $verifyTransaction->transactionServices->count(),
                'total_amount_matches' => $verifyTransaction->total_amount == $totalAmount
            ]);

            if (!$verifyTransaction) {
                throw new \Exception('Transaction was not created properly.');
            }

            // Return with detailed success message
            $successMessage = "Order #$transaction->invoice_number created successfully!\n" .
                "Customer: {$customer->name}\n" .
                "Total Amount: Rp " . number_format($totalAmount, 0, ',', '.') . "\n" .
                "Status: Pending";

            // Debug: Log success message
            Log::info('Order creation successful', [
                'message' => $successMessage
            ]);

            return redirect()->route('employee.transactions.show', $transaction)
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create transaction', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'customer_id' => $request->customer_id,
                'branch_id' => auth()->user()->branch->id ?? null,
                'services' => $request->services
            ]);
            return back()->withInput()
                ->with('error', 'Failed to create order. ' . $e->getMessage());
        }
    }
} 