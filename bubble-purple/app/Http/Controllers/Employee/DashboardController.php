<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $branch = auth()->user()->branch;

        // Get branch transactions
        $recentTransactions = Transaction::with(['customer', 'transactionServices.service'])
            ->where('branch_id', $branch->id)
            ->latest()
            ->take(10)
            ->get();

        // Transaction statistics
        $totalTransactions = Transaction::where('branch_id', $branch->id)->count();
        $pendingTransactions = Transaction::where('branch_id', $branch->id)
            ->where('status', 'pending')
            ->count();
        $processingTransactions = Transaction::where('branch_id', $branch->id)
            ->where('status', 'processing')
            ->count();
        $completedTransactions = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->count();

        // Financial statistics
        $totalRevenue = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->sum('total_amount');
        $monthlyRevenue = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        // Monthly trend
        $monthlyTrend = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Active orders (pending and processing)
        $activeOrders = Transaction::with(['customer', 'transactionServices.service'])
            ->where('branch_id', $branch->id)
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->get();

        return view('employee.dashboard', compact(
            'recentTransactions',
            'totalTransactions',
            'pendingTransactions',
            'processingTransactions',
            'completedTransactions',
            'totalRevenue',
            'monthlyRevenue',
            'monthlyTrend',
            'activeOrders',
            'branch'
        ));
    }
}
