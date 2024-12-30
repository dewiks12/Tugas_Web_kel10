<?php

namespace App\Http\Controllers\Employee;

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
        $branch = $user->branch;

        // Get today's statistics
        $today = Carbon::today();
        $todayStats = [
            'orders' => Transaction::where('branch_id', $branch->id)
                ->whereDate('created_at', $today)
                ->count(),
            'revenue' => Transaction::where('branch_id', $branch->id)
                ->whereDate('created_at', $today)
                ->sum('total_amount'),
            'pending_orders' => Transaction::where('branch_id', $branch->id)
                ->whereDate('created_at', $today)
                ->where('status', 'pending')
                ->count(),
        ];

        // Get this month's statistics
        $thisMonth = Carbon::now()->startOfMonth();
        $monthlyStats = [
            'orders' => Transaction::where('branch_id', $branch->id)
                ->whereMonth('created_at', $thisMonth->month)
                ->count(),
            'revenue' => Transaction::where('branch_id', $branch->id)
                ->whereMonth('created_at', $thisMonth->month)
                ->sum('total_amount'),
            'completed_orders' => Transaction::where('branch_id', $branch->id)
                ->whereMonth('created_at', $thisMonth->month)
                ->where('status', 'completed')
                ->count(),
        ];

        // Get branch target
        $branchTarget = $branch->targets()
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->first();

        // Get recent transactions
        $recentTransactions = Transaction::with('customer')
            ->where('branch_id', $branch->id)
            ->latest()
            ->take(5)
            ->get();

        // Get orders by status
        $ordersByStatus = Transaction::where('branch_id', $branch->id)
            ->whereMonth('created_at', $thisMonth->month)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return view('employee.dashboard', compact(
            'todayStats',
            'monthlyStats',
            'branchTarget',
            'recentTransactions',
            'ordersByStatus'
        ));
    }
}
