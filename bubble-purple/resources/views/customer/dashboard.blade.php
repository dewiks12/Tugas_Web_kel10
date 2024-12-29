<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <svg class="w-8 h-8 text-purple-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">My Dashboard</h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Active Orders -->
        <div class="card transform hover:scale-105 transition-transform duration-300">
            <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Active Orders</h3>
                    </div>
                    <a href="{{ route('customer.transactions.index') }}" class="text-sm text-purple-600 hover:text-purple-500 dark:text-purple-300 dark:hover:text-purple-200">
                        View all orders
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($activeOrders->isEmpty())
                    <div class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-purple-500 dark:text-purple-400">No active orders</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($activeOrders as $order)
                            <div class="flex items-center justify-between transform hover:scale-105 transition-transform duration-200">
                                <div>
                                    <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                        Order #{{ $order->invoice_number }}
                                    </p>
                                    <p class="text-sm text-purple-500 dark:text-purple-400">
                                        {{ $order->branch->name }}
                                    </p>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-purple-500 dark:text-purple-400">
                                        {{ $order->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Spent -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-purple-50 to-white dark:from-purple-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-300">Total Spent</p>
                            <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">
                                Rp {{ number_format($totalSpent, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-800 rounded-full animate-bounce">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Orders This Month -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-green-50 to-white dark:from-green-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-300">Completed Orders This Month</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-200">{{ $completedOrders->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-800 rounded-full animate-bounce">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Orders -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-yellow-50 to-white dark:from-yellow-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-600 dark:text-yellow-300">Active Orders</p>
                            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-200">{{ $activeOrders->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-800 rounded-full animate-bounce">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History & Frequent Services -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Order History -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Order History</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach($orderHistory as $history)
                            <div class="transform hover:scale-105 transition-transform duration-200">
                                <div class="flex justify-between text-sm font-medium">
                                    <span class="text-purple-600 dark:text-purple-300">{{ Carbon\Carbon::createFromFormat('Y-m', $history->month)->format('F Y') }}</span>
                                    <span class="text-purple-900 dark:text-purple-100">{{ $history->count }} orders</span>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-purple-500 dark:text-purple-400">
                                        Total spent: Rp {{ number_format($history->total, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Frequent Services -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Frequently Used Services</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach($frequentServices as $service)
                            <div class="flex items-center justify-between transform hover:scale-105 transition-transform duration-200">
                                <div>
                                    <p class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ $service->name }}</p>
                                    <p class="text-sm text-purple-500 dark:text-purple-400">Used {{ $service->count }} times</p>
                                </div>
                                <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 