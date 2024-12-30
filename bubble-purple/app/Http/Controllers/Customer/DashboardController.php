<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Active Orders (pending and processing)
        $activeOrders = Transaction::where('customer_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->with(['branch', 'transactionServices.service'])
            ->latest()
            ->get();

        // Order Statistics
        $totalOrders = Transaction::where('customer_id', $user->id)->count();
        $pendingOrders = Transaction::where('customer_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedOrders = Transaction::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Order Status Distribution
        $ordersByStatus = [
            'pending' => Transaction::where('customer_id', $user->id)->where('status', 'pending')->count(),
            'processing' => Transaction::where('customer_id', $user->id)->where('status', 'processing')->count(),
            'completed' => Transaction::where('customer_id', $user->id)->where('status', 'completed')->count(),
            'cancelled' => Transaction::where('customer_id', $user->id)->where('status', 'cancelled')->count(),
        ];

        // Recent Orders
        $recentOrders = Transaction::where('customer_id', $user->id)
            ->with(['branch', 'transactionServices.service'])
            ->latest()
            ->take(5)
            ->get();

        // Financial Statistics
        $totalSpent = Transaction::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_amount');

        $monthlySpent = Transaction::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        return view('customer.dashboard', compact(
            'activeOrders',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'ordersByStatus',
            'recentOrders',
            'totalSpent',
            'monthlySpent'
        ));
    }
}
