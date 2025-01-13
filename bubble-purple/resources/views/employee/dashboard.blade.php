@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 mb-0">{{ __('Employee Dashboard') }} - {{ $branch->name }}</h2>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="row mb-4">
        <!-- Total Transactions -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Total Transactions</h6>
                        <span class="h3 text-primary mb-0">{{ $totalTransactions }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Total Revenue</h6>
                        <span class="h3 text-primary mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Monthly Revenue</h6>
                        <span class="h3 text-primary mb-0">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Pending Orders</h6>
                        <span class="h3 text-primary mb-0">{{ $pendingTransactions }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Status & Monthly Trend -->
    <div class="row mb-4">
        <!-- Status Distribution -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Transaction Status</h5>
                    <!-- Pending -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Pending</span>
                            <span>{{ $pendingTransactions }} / {{ $totalTransactions }}</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                style="width: {{ ($totalTransactions > 0) ? ($pendingTransactions / $totalTransactions * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <!-- Processing -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Processing</span>
                            <span>{{ $processingTransactions }} / {{ $totalTransactions }}</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" 
                                style="width: {{ ($totalTransactions > 0) ? ($processingTransactions / $totalTransactions * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <!-- Completed -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Completed</span>
                            <span>{{ $completedTransactions }} / {{ $totalTransactions }}</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: {{ ($totalTransactions > 0) ? ($completedTransactions / $totalTransactions * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Trend -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Monthly Revenue Trend</h5>
                    <div style="height: 300px;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Orders -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Active Orders</h5>
                <a href="{{ route('employee.orders.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Create Order
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Services</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($order->transactionServices as $service)
                                            <li>{{ $service->service->name }} ({{ $service->quantity }}x)</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <span class="badge {{ $order->status === 'completed' ? 'bg-success' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-info' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('employee.transactions.show', $order) }}" class="btn btn-sm btn-primary">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No active orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Recent Transactions</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->customer->name }}</td>
                                <td>
                                    <span class="badge {{ $transaction->status === 'completed' ? 'bg-success' : '' }}
                                        {{ $transaction->status === 'pending' ? 'bg-warning' : '' }}
                                        {{ $transaction->status === 'processing' ? 'bg-info' : '' }}
                                        {{ $transaction->status === 'cancelled' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('employee.transactions.show', $transaction) }}" class="btn btn-sm btn-primary">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Trend Chart
    const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
    const monthlyTrendData = @json($monthlyTrend);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyTrendData.map(item => {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[item.month - 1];
            }),
            datasets: [{
                label: 'Revenue',
                data: monthlyTrendData.map(item => item.revenue),
                borderColor: '#0d6efd',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection 