<x-employee-layout>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Today's Orders -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Today's Orders</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $todayOrders }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Pickups -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pending Pickups</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingPickups }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Today's Revenue</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($todayRevenue, 0, ',', '.') }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('employee.transactions.create') }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-12 text-center hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">New Transaction</span>
            </a>

            <a href="{{ route('employee.customers.create') }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-12 text-center hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">New Customer</span>
            </a>

            <a href="{{ route('employee.transactions.index', ['status' => 'pending']) }}" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-12 text-center hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">View Pending Orders</span>
            </a>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Recent Transactions</h2>
            <a href="{{ route('employee.transactions.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">View all</a>
        </div>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pickup Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->invoice_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $transaction->customer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ number_format($transaction->final_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($transaction->status === 'completed') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @elseif($transaction->status === 'processing') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                                @endif">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $transaction->pickup_date ? $transaction->pickup_date->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-employee-layout> 