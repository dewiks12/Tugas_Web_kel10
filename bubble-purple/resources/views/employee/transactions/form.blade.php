<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ isset($transaction) ? 'Edit Transaction' : 'Create Transaction' }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ isset($transaction) ? 'Edit an existing transaction in the system.' : 'Add a new transaction to the system.' }}</p>
        </div>
    </div>

    <div class="mt-8">
        <form action="{{ isset($transaction) ? route('employee.transactions.update', $transaction) : route('employee.transactions.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($transaction))
                @method('PUT')
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Customer -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                        <select name="customer_id" id="customer_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $transaction->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Services -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Services</label>
                        <div class="space-y-4" id="services-container">
                            @if(isset($transaction))
                                @foreach($transaction->items as $item)
                                    <div class="service-item grid grid-cols-12 gap-4">
                                        <div class="col-span-4">
                                            <select name="services[]" class="service-select mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                                                <option value="">Select Service</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ $item->service_id == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-2">
                                            <input type="number" name="quantities[]" value="{{ $item->quantity }}" step="0.01" min="0.01" class="quantity-input mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Quantity" required>
                                        </div>
                                        <div class="col-span-2">
                                            <input type="number" name="prices[]" value="{{ $item->price }}" class="price-input mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Price" readonly>
                                        </div>
                                        <div class="col-span-3">
                                            <input type="number" name="subtotals[]" value="{{ $item->subtotal }}" class="subtotal-input mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Subtotal" readonly>
                                        </div>
                                        <div class="col-span-1 flex items-center justify-center mt-1">
                                            <button type="button" class="remove-service text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="service-item grid grid-cols-12 gap-4">
                                    <div class="col-span-4">
                                        <select name="services[]" class="service-select mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                    {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="number" name="quantities[]" step="0.01" min="0.01" class="quantity-input mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Quantity" required>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="number" name="prices[]" class="price-input mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Price" readonly>
                                    </div>
                                    <div class="col-span-3">
                                        <input type="number" name="subtotals[]" class="subtotal-input mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Subtotal" readonly>
                                    </div>
                                    <div class="col-span-1 flex items-center justify-center mt-1">
                                        <button type="button" class="remove-service text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <button type="button" id="add-service" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Add Service
                            </button>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount</label>
                        <input type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', $transaction->total_amount ?? 0) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" readonly>
                        @error('total_amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                            <option value="pending" {{ old('status', $transaction->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ old('status', $transaction->status ?? '') === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ old('status', $transaction->status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $transaction->status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pickup Date -->
                    <div>
                        <label for="pickup_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Date</label>
                        <input type="datetime-local" name="pickup_date" id="pickup_date" value="{{ old('pickup_date', $transaction->pickup_date?->format('Y-m-d\TH:i') ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        @error('pickup_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ old('notes', $transaction->notes ?? '') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right sm:px-6 space-x-3">
                    <a href="{{ route('employee.transactions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        {{ isset($transaction) ? 'Update Transaction' : 'Create Transaction' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const servicesContainer = document.getElementById('services-container');
            const addServiceButton = document.getElementById('add-service');
            const totalAmountInput = document.getElementById('total_amount');

            // Function to create a new service item
            function createServiceItem() {
                const template = servicesContainer.querySelector('.service-item').cloneNode(true);
                template.querySelectorAll('input').forEach(input => input.value = '');
                template.querySelector('select').selectedIndex = 0;
                return template;
            }

            // Function to update calculations
            function updateCalculations(item) {
                const serviceSelect = item.querySelector('.service-select');
                const quantityInput = item.querySelector('.quantity-input');
                const priceInput = item.querySelector('.price-input');
                const subtotalInput = item.querySelector('.subtotal-input');

                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const price = selectedOption.dataset.price || 0;
                const quantity = quantityInput.value || 0;

                priceInput.value = price;
                subtotalInput.value = (price * quantity).toFixed(2);

                // Update total amount
                const subtotals = [...document.querySelectorAll('.subtotal-input')].map(input => parseFloat(input.value) || 0);
                totalAmountInput.value = subtotals.reduce((a, b) => a + b, 0).toFixed(2);
            }

            // Add new service
            addServiceButton.addEventListener('click', () => {
                const newItem = createServiceItem();
                servicesContainer.appendChild(newItem);
            });

            // Remove service
            servicesContainer.addEventListener('click', (e) => {
                if (e.target.closest('.remove-service')) {
                    const item = e.target.closest('.service-item');
                    if (servicesContainer.querySelectorAll('.service-item').length > 1) {
                        item.remove();
                        updateCalculations(item);
                    }
                }
            });

            // Update calculations on change
            servicesContainer.addEventListener('change', (e) => {
                if (e.target.matches('.service-select') || e.target.matches('.quantity-input')) {
                    const item = e.target.closest('.service-item');
                    updateCalculations(item);
                }
            });

            // Initialize calculations
            document.querySelectorAll('.service-item').forEach(item => updateCalculations(item));
        });
    </script>
    @endpush
</x-app-layout> 