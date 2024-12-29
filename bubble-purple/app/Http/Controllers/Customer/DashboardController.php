<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get active orders
        $activeOrders = Transaction::where('customer_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->with(['branch', 'items.service'])
            ->latest()
            ->get();

        // Get completed orders this month
        $thisMonth = Carbon::now()->startOfMonth();
        $completedOrders = Transaction::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->whereMonth('created_at', $thisMonth->month)
            ->with(['branch', 'items.service'])
            ->latest()
            ->get();

        // Calculate total spent
        $totalSpent = Transaction::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Get order history by month
        $orderHistory = Transaction::where('customer_id', $user->id)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count, sum(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // Get frequently used services
        $frequentServices = Transaction::where('customer_id', $user->id)
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->join('services', 'transaction_items.service_id', '=', 'services.id')
            ->selectRaw('services.name, services.price, count(*) as count')
            ->groupBy('services.id', 'services.name', 'services.price')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact(
            'activeOrders',
            'completedOrders',
            'totalSpent',
            'orderHistory',
            'frequentServices'
        ));
    }
}
