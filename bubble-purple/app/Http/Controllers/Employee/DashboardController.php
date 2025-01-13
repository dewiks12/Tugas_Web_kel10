<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $branch = auth()->user()->branch;
        
        if (!$branch) {
            abort(403, 'You are not assigned to any branch. Please contact your administrator.');
        }

        // Customer statistics
        $branchCustomers = Transaction::where('branch_id', $branch->id)
            ->distinct('customer_id')
            ->count('customer_id');

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
        $cancelledTransactions = Transaction::where('branch_id', $branch->id)
            ->where('status', 'cancelled')
            ->count();

        // Financial statistics
        $totalRevenue = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->sum('total_amount');
        $monthlyRevenue = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');
        $dailyRevenue = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
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

        // Service performance
        $servicePerformance = Transaction::where('branch_id', $branch->id)
            ->where('status', 'completed')
            ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->join('transaction_services', 'transactions.id', '=', 'transaction_services.transaction_id')
            ->join('services', 'transaction_services.service_id', '=', 'services.id')
            ->select(
                'services.name',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(transaction_services.quantity) as total_quantity'),
                DB::raw('SUM(transaction_services.subtotal) as total_revenue')
            )
            ->groupBy('services.id', 'services.name')
            ->get();

        // Active orders (pending and processing)
        $activeOrders = Transaction::with(['customer', 'transactionServices.service'])
            ->where('branch_id', $branch->id)
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['customer', 'transactionServices.service'])
            ->where('branch_id', $branch->id)
            ->latest()
            ->take(10)
            ->get();

        return view('employee.dashboard', compact(
            'branch',
            'branchCustomers',
            'totalTransactions',
            'pendingTransactions',
            'processingTransactions',
            'completedTransactions',
            'cancelledTransactions',
            'totalRevenue',
            'monthlyRevenue',
            'dailyRevenue',
            'monthlyTrend',
            'servicePerformance',
            'activeOrders',
            'recentTransactions'
        ));
    }
}
