<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-purple-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Employee Dashboard</h2>
            </div>
            <a href="{{ route('employee.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Order
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Today's Stats -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Orders Today -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-purple-50 to-white dark:from-purple-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-300">Orders Today</p>
                            <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">{{ $todayStats['orders'] }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-800 rounded-full animate-bounce">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Today -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-green-50 to-white dark:from-green-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-300">Revenue Today</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-200">
                                Rp {{ number_format($todayStats['revenue'], 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-800 rounded-full animate-bounce">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-yellow-50 to-white dark:from-yellow-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-600 dark:text-yellow-300">Pending Orders</p>
                            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-200">{{ $todayStats['pending_orders'] }}</p>
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

        <!-- Branch Target -->
        @if($branchTarget)
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Branch Target</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <!-- Amount Target -->
                        <div class="transform hover:scale-105 transition-transform duration-200">
                            <div class="flex justify-between text-sm font-medium">
                                <span class="text-purple-600 dark:text-purple-300">Revenue Target</span>
                                <span class="text-purple-900 dark:text-purple-100">
                                    {{ number_format(($branchTarget->target_amount > 0 ? ($branchTarget->achieved_amount / $branchTarget->target_amount * 100) : 0), 1) }}%
                                    (Rp {{ number_format($branchTarget->achieved_amount, 0, ',', '.') }} / {{ number_format($branchTarget->target_amount, 0, ',', '.') }})
                                </span>
                            </div>
                            <div class="mt-2 relative pt-1">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-purple-200 dark:bg-purple-700">
                                    <div style="width: {{ $branchTarget->target_amount > 0 ? ($branchTarget->achieved_amount / $branchTarget->target_amount * 100) : 0 }}%" 
                                         class="animate-pulse shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Orders by Status & Recent Transactions -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Orders by Status -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Orders by Status</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                            <div class="transform hover:scale-105 transition-transform duration-200">
                                <div class="flex justify-between text-sm font-medium">
                                    <span class="text-purple-600 dark:text-purple-300">{{ ucfirst($status) }}</span>
                                    <span class="text-purple-900 dark:text-purple-100">{{ $ordersByStatus[$status] ?? 0 }}</span>
                                </div>
                                <div class="mt-2 relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-purple-200 dark:bg-purple-700">
                                        @php
                                            $total = array_sum($ordersByStatus);
                                            $percentage = $total > 0 ? (($ordersByStatus[$status] ?? 0) / $total * 100) : 0;
                                        @endphp
                                        <div style="width: {{ $percentage }}%" 
                                             class="animate-pulse shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center 
                                             {{ $status === 'pending' ? 'bg-yellow-500' : 
                                                ($status === 'processing' ? 'bg-blue-500' : 
                                                ($status === 'completed' ? 'bg-green-500' : 'bg-red-500')) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Recent Transactions</h3>
                        </div>
                        <a href="{{ route('employee.transactions.index') }}" class="text-sm text-purple-600 hover:text-purple-500 dark:text-purple-300 dark:hover:text-purple-200">
                            View all
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @forelse($recentTransactions as $transaction)
                            <div class="flex items-center justify-between transform hover:scale-105 transition-transform duration-200">
                                <div class="flex items-center">
                                    <div>
                                        <p class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ $transaction->customer->name }}</p>
                                        <p class="text-sm text-purple-500 dark:text-purple-400">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : 
                                                   ($transaction->status === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : 
                                                   ($transaction->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100')) }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-purple-500 dark:text-purple-400">
                                        {{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400">
                                No recent transactions
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 