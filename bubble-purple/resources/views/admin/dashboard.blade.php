@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 mb-0">Admin Dashboard</h2>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <!-- Total Customers -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Customers</h6>
                            <h2 class="mt-2 mb-0">{{ number_format($totalCustomers) }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Revenue</h6>
                            <h2 class="mt-2 mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-cash-stack fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Monthly Revenue</h6>
                            <h2 class="mt-2 mb-0">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-graph-up fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Branches -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Active Branches</h6>
                            <h2 class="mt-2 mb-0">{{ number_format($activeBranches) }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-shop fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status & Monthly Trend -->
    <div class="row mb-4">
        <!-- Order Status -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Order Status</h5>
                    <div class="mt-4">
                        <!-- Pending -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Pending</span>
                                <span class="fw-bold">{{ $pendingOrders }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ ($totalOrders > 0) ? ($pendingOrders / $totalOrders * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Processing -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Processing</span>
                                <span class="fw-bold">{{ $processingOrders }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: {{ ($totalOrders > 0) ? ($processingOrders / $totalOrders * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Completed -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Completed</span>
                                <span class="fw-bold">{{ $completedOrders }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: {{ ($totalOrders > 0) ? ($completedOrders / $totalOrders * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Cancelled -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Cancelled</span>
                                <span class="fw-bold">{{ $cancelledOrders }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger" style="width: {{ ($totalOrders > 0) ? ($cancelledOrders / $totalOrders * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Trend -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Monthly Revenue Trend</h5>
                    <div style="height: 300px;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Branch Performance -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Branch Performance</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Completed Orders</th>
                            <th>Total Revenue</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branchPerformance as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>{{ number_format($branch->completed_orders) }}</td>
                                <td>Rp {{ number_format($branch->total_revenue ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <div class="progress" style="height: 8px; width: 100px;">
                                        @php
                                            $maxRevenue = $branchPerformance->max('total_revenue') ?: 1;
                                            $percentage = ($branch->total_revenue ?? 0) / $maxRevenue * 100;
                                        @endphp
                                        <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Recent Orders</h5>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary btn-sm">
                    View All Orders
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Branch</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->invoice_number }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->branch->name }}</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $order->status === 'completed' ? 'bg-success' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-info' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.transactions.show', $order) }}" class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No orders found</td>
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
                tension: 0.1,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)'
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