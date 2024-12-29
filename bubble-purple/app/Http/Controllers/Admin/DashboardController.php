<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LaundryTarget;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for today
        $today = Carbon::today();
        $todayStats = [
            'orders' => Transaction::whereDate('created_at', $today)->count(),
            'revenue' => Transaction::whereDate('created_at', $today)->sum('total_amount'),
            'new_customers' => User::whereDate('created_at', $today)
                ->whereHas('role', fn($q) => $q->where('slug', 'customer'))
                ->count(),
        ];

        // Get statistics for this month
        $thisMonth = Carbon::now()->startOfMonth();
        $monthlyStats = [
            'orders' => Transaction::whereMonth('created_at', $thisMonth->month)->count(),
            'revenue' => Transaction::whereMonth('created_at', $thisMonth->month)->sum('total_amount'),
            'new_customers' => User::whereMonth('created_at', $thisMonth->month)
                ->whereHas('role', fn($q) => $q->where('slug', 'customer'))
                ->count(),
        ];

        // Get active targets
        $activeTargets = LaundryTarget::with('branch')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        // Get revenue by branch for the current month
        $revenueByBranch = Transaction::select('branch_id', DB::raw('sum(total_amount) as total'))
            ->whereMonth('created_at', $thisMonth->month)
            ->groupBy('branch_id')
            ->with('branch')
            ->get();

        // Get popular services
        $popularServices = Service::withCount(['transactionItems as usage_count' => function($query) use ($thisMonth) {
            $query->whereMonth('created_at', $thisMonth->month);
        }])
        ->orderByDesc('usage_count')
        ->take(5)
        ->get();

        // Get recent transactions
        $recentTransactions = Transaction::with(['customer', 'branch'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'todayStats',
            'monthlyStats',
            'activeTargets',
            'revenueByBranch',
            'popularServices',
            'recentTransactions'
        ));
    }
}
