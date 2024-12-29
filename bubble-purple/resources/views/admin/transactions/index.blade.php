<x-admin-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Transactions</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all transactions in the system including their invoice number, customer, amount, and status.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.transactions.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto">
                Add Transaction
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.transactions.index') }}" method="GET" class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                <div class="sm:w-1/4">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Invoice number or customer name">
                </div>
                <div class="sm:w-1/4">
                    <label for="branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Branch</label>
                    <select id="branch" name="branch" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:w-1/4">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="sm:w-1/4 sm:flex sm:items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Branch</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pickup Date</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->invoice_number }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->customer->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $transaction->customer->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $transaction->branch->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-800 dark:bg-{{ $transaction->status_color }}-800 dark:text-{{ $transaction->status_color }}-100">
                                {{ $transaction->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $transaction->pickup_date?->format('d/m/Y H:i') ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">View</a>
                                <a href="{{ route('admin.transactions.edit', $transaction) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">Edit</a>
                                <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</x-admin-layout> 