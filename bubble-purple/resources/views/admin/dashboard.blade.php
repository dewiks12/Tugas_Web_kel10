<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <svg class="w-8 h-8 text-purple-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Admin Dashboard</h2>
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

            <!-- New Customers Today -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-blue-50 to-white dark:from-blue-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-300">New Customers Today</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">{{ $todayStats['new_customers'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-800 rounded-full animate-bounce">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Stats -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Orders This Month -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-purple-50 to-white dark:from-purple-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-300">Orders This Month</p>
                            <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">{{ $monthlyStats['orders'] }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-800 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue This Month -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-green-50 to-white dark:from-green-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-300">Revenue This Month</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-200">
                                Rp {{ number_format($monthlyStats['revenue'], 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-800 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Customers This Month -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-body bg-gradient-to-br from-blue-50 to-white dark:from-blue-900 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-300">New Customers This Month</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-200">{{ $monthlyStats['new_customers'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-800 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branch Performance -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Revenue by Branch -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Revenue by Branch</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach($revenueByBranch as $revenue)
                            <div class="transform hover:scale-105 transition-transform duration-200">
                                <div class="flex justify-between text-sm font-medium">
                                    <span class="text-purple-600 dark:text-purple-300">{{ $revenue->branch->name }}</span>
                                    <span class="text-purple-900 dark:text-purple-100">Rp {{ number_format($revenue->total, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-2 relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-purple-200 dark:bg-purple-700">
                                        <div style="width: {{ ($revenue->total / $revenueByBranch->max('total')) * 100 }}%" 
                                             class="animate-pulse shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Active Targets -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Active Targets</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @forelse($activeTargets as $target)
                            <div class="transform hover:scale-105 transition-transform duration-200">
                                <div class="flex justify-between text-sm font-medium">
                                    <span class="text-purple-600 dark:text-purple-300">{{ $target->branch->name }}</span>
                                    <span class="text-purple-900 dark:text-purple-100">{{ $target->amount_progress }}%</span>
                                </div>
                                <div class="mt-2 relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-purple-200 dark:bg-purple-700">
                                        <div style="width: {{ $target->amount_progress }}%" 
                                             class="animate-pulse shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <svg class="mx-auto h-12 w-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-2 text-purple-500 dark:text-purple-400">No active targets</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Services & Recent Transactions -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Popular Services -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Popular Services</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach($popularServices as $service)
                            <div class="flex items-center justify-between transform hover:scale-105 transition-transform duration-200">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ $service->name }}</p>
                                        <p class="text-sm text-purple-500 dark:text-purple-400">{{ $service->usage_count }} orders</p>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-purple-900 dark:text-purple-100">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card transform hover:scale-105 transition-transform duration-300">
                <div class="card-header bg-gradient-to-r from-purple-100 to-transparent dark:from-purple-900 dark:to-transparent">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Recent Transactions</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach($recentTransactions as $transaction)
                            <div class="flex items-center justify-between transform hover:scale-105 transition-transform duration-200">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-purple-900 dark:text-purple-100">{{ $transaction->customer->name }}</p>
                                        <p class="text-sm text-purple-500 dark:text-purple-400">{{ $transaction->branch->name }}</p>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 