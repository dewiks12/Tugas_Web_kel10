<x-customer-layout>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Total Orders -->
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Orders</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalOrders }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Orders -->
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Orders</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $activeOrders }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Spent -->
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Spent</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalSpent, 0, ',', '.') }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Recent Orders</h2>
            <a href="{{ route('customer.transactions.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">View all</a>
        </div>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Branch</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pickup Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            <a href="{{ route('customer.transactions.show', $order) }}" class="hover:text-purple-600">
                                {{ $order->invoice_number }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $order->branch->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ number_format($order->final_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status === 'completed') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $order->pickup_date ? $order->pickup_date->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-customer-layout> 