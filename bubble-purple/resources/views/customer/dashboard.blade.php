@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 mb-0">Customer Dashboard</h2>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Orders</h6>
                            <h2 class="mt-2 mb-0">{{ number_format($totalOrders) }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-receipt fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Orders -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Active Orders</h6>
                            <h2 class="mt-2 mb-0">{{ $activeOrders->count() }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock-history fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Total Spent</h6>
                            <h2 class="mt-2 mb-0">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-cash-stack fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Spent -->
        <div class="col-md-3">
            <div class="card bg-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-0">Monthly Spent</h6>
                            <h2 class="mt-2 mb-0">Rp {{ number_format($monthlySpent, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-calendar-check fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Orders -->
    @if($activeOrders->isNotEmpty())
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Active Orders</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Branch</th>
                            <th>Services</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->branch->name }}</td>
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
                                        {{ $order->status === 'processing' ? 'bg-primary' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('customer.transactions.show', $order) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Orders by Status -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Orders by Status</h5>
        </div>
        <div class="card-body">
            @foreach($ordersByStatus as $status => $count)
                @php
                    $percentage = $totalOrders > 0 ? number_format(($count / $totalOrders * 100), 1) : 0;
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>{{ ucfirst($status) }}</span>
                        <span>{{ $count }} / {{ $totalOrders }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar {{ $status === 'completed' ? 'bg-success' : '' }}
                            {{ $status === 'pending' ? 'bg-warning' : '' }}
                            {{ $status === 'processing' ? 'bg-primary' : '' }}
                            {{ $status === 'cancelled' ? 'bg-danger' : '' }}"
                            role="progressbar" 
                            style="width: {{ $percentage }}%" 
                            aria-valuenow="{{ $percentage }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Recent Orders</h5>
            <a href="{{ route('customer.transactions.index') }}" class="btn btn-sm btn-primary">
                View All Orders
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->branch->name }}</td>
                                <td>
                                    <span class="badge {{ $order->status === 'completed' ? 'bg-success' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-primary' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('customer.transactions.show', $order) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 