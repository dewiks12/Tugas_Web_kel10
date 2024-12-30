<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Transaction #{{ $transaction->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <!-- Transaction Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Transaction Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Customer</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $transaction->customer->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Branch</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $transaction->branch->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                                <p class="text-base font-medium">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'text-yellow-600 dark:text-yellow-400',
                                            'processing' => 'text-blue-600 dark:text-blue-400',
                                            'completed' => 'text-green-600 dark:text-green-400',
                                            'cancelled' => 'text-red-600 dark:text-red-400'
                                        ];
                                    @endphp
                                    <span class="{{ $statusClasses[$transaction->status] }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Created At</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Updated At</p>
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    {{ $transaction->updated_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Services</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($transaction->transactionServices as $service)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $service->service->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $service->quantity }} {{ $service->service->unit }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                Rp {{ number_format($service->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                Rp {{ number_format($service->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 text-right">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Information</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            @if($transaction->payment_status === 'paid')
                                <div class="flex items-center text-green-600 dark:text-green-400 mb-4">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">Payment Completed</span>
                                </div>
                                @if($transaction->payment_details)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Payment Method</p>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                                {{ ucfirst($transaction->payment_details['payment_type'] ?? 'N/A') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Transaction ID</p>
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                                {{ $transaction->payment_details['transaction_id'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">Payment is pending</p>
                                    @if($transaction->status === 'pending')
                                        <button onclick="updateStatus('{{ $transaction->id }}', 'processing')"
                                                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring focus:ring-purple-300 disabled:opacity-25 transition">
                                            Process Order
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Currency Rates -->
                    <div class="mb-8" x-data="{ rates: null }">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Currency Exchange Rates</h3>
                        <button @click="if (!rates) { fetch('/admin/api/currency-rates').then(r => r.json()).then(data => rates = data.rates) }"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Load Exchange Rates
                        </button>
                        <div x-show="rates" x-cloak class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <template x-for="(rate, currency) in rates" :key="currency">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="currency"></p>
                                    <p class="text-lg font-bold text-purple-600 dark:text-purple-400" x-text="rate"></p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Weather Information -->
                    <div x-data="{ weather: null }">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Local Weather</h3>
                        <button @click="if (!weather) { fetch('/admin/api/weather').then(r => r.json()).then(data => weather = data) }"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Load Weather Info
                        </button>
                        <div x-show="weather" x-cloak class="mt-4 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100" x-text="weather.main.temp + '°C'"></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400" x-text="weather.weather[0].description"></p>
                                </div>
                                <img :src="'http://openweathermap.org/img/w/' + weather.weather[0].icon + '.png'" 
                                     class="w-16 h-16"
                                     :alt="weather.weather[0].description">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Humidity</p>
                                    <p class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="weather.main.humidity + '%'"></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Wind Speed</p>
                                    <p class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="weather.wind.speed + ' m/s'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateStatus(transactionId, newStatus) {
            if (!confirm('Are you sure you want to update the status?')) {
                return;
            }

            const headers = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            };

            fetch(`/admin/transactions/${transactionId}/status`, {
                method: 'PATCH',
                headers: headers,
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update status. Please try again.');
            });
        }
    </script>
    @endpush
</x-app-layout> 