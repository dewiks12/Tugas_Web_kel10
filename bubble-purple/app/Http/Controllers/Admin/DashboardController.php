<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Customer statistics
        $totalCustomers = User::whereHas('role', function($query) {
            $query->where('name', 'customer');
        })->count();

        // Branch statistics
        $activeBranches = Branch::where('is_active', true)->count();

        // Transaction statistics
        $totalOrders = Transaction::count();
        $totalRevenue = Transaction::where('status', 'completed')->sum('total_amount');
        $monthlyRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        // Status counts
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $processingOrders = Transaction::where('status', 'processing')->count();
        $completedOrders = Transaction::where('status', 'completed')->count();
        $cancelledOrders = Transaction::where('status', 'cancelled')->count();

        // Monthly trend
        $monthlyTrend = Transaction::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Branch performance
        $branchPerformance = Branch::withCount(['transactions as completed_orders' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['transactions as total_revenue' => function($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->where('is_active', true)
            ->get();

        // Recent orders
        $recentOrders = Transaction::with(['customer', 'branch'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'activeBranches',
            'totalOrders',
            'totalRevenue',
            'monthlyRevenue',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'monthlyTrend',
            'branchPerformance',
            'recentOrders'
        ));
    }
}
