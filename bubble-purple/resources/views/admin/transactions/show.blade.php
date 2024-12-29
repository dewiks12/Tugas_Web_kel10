<x-admin-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Transaction Details</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Detailed information about the transaction.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none space-x-3">
            <a href="{{ route('admin.transactions.edit', $transaction) }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto">
                Edit Transaction
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto">
                Back to List
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Invoice Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->invoice_number }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-800 dark:bg-{{ $transaction->status_color }}-800 dark:text-{{ $transaction->status_color }}-100">
                            {{ $transaction->status_label }}
                        </span>
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $transaction->customer->name }}<br>
                        <span class="text-gray-500 dark:text-gray-400">{{ $transaction->customer->phone }}</span>
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Branch</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->branch->name }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->user->name }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pickup Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->pickup_date?->format('d/m/Y H:i') ?? '-' }}</dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $transaction->notes ?? '-' }}</dd>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Services</h3>
            <div class="mt-4">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($transaction->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $item->service->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $item->quantity }} {{ $item->service->unit }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">Total Amount:</th>
                                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 