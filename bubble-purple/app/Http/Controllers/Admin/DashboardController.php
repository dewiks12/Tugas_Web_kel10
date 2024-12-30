<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all transactions
        $recentTransactions = Transaction::with(['customer', 'branch', 'transactionServices.service'])
            ->latest()
            ->take(10)
            ->get();

        // Transaction statistics
        $totalTransactions = Transaction::count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $processingTransactions = Transaction::where('status', 'processing')->count();
        $completedTransactions = Transaction::where('status', 'completed')->count();

        // Financial statistics
        $totalRevenue = Transaction::where('status', 'completed')->sum('total_amount');
        $monthlyRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        // Branch statistics
        $branchRevenue = Branch::withSum(['transactions' => function($query) {
            $query->where('status', 'completed');
        }], 'total_amount')
            ->withCount(['transactions as pending_count' => function($query) {
                $query->where('status', 'pending');
            }])
            ->withCount(['transactions as processing_count' => function($query) {
                $query->where('status', 'processing');
            }])
            ->withCount(['transactions as completed_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->get();

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

        return view('admin.dashboard', compact(
            'recentTransactions',
            'totalTransactions',
            'pendingTransactions',
            'processingTransactions',
            'completedTransactions',
            'totalRevenue',
            'monthlyRevenue',
            'branchRevenue',
            'monthlyTrend'
        ));
    }
}
