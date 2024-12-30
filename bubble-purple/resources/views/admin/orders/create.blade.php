<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.orders.store') }}" method="POST" x-data="orderForm()">
                        @csrf

                        <!-- Customer Selection -->
                        <div class="mb-6">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                            <select name="customer_id" id="customer_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch Selection -->
                        <div class="mb-6">
                            <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Branch</label>
                            <select name="branch_id" id="branch_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Services -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Services</label>
                            <template x-for="(item, index) in services" :key="index">
                                <div class="flex gap-4 mb-4">
                                    <div class="flex-1">
                                        <select :name="'services['+index+'][id]'" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500" x-model="item.id">
                                            <option value="">Select Service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-32">
                                        <input type="number" :name="'services['+index+'][quantity]'" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500" placeholder="Qty" min="1" x-model="item.quantity">
                                    </div>
                                    <div class="w-32 flex items-center">
                                        <span class="text-gray-600 dark:text-gray-400" x-text="formatPrice(calculateSubtotal(item))"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <button type="button" class="text-red-600 hover:text-red-800" @click="removeService(index)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <button type="button" class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" @click="addService">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Service
                            </button>

                            @error('services')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Amount -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center py-3 px-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Amount</span>
                                <span class="text-2xl font-bold text-purple-600 dark:text-purple-400" x-text="formatPrice(calculateTotal())"></span>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500" placeholder="Add any special instructions or notes here">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring focus:ring-purple-300 disabled:opacity-25 transition">
                                Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function orderForm() {
            return {
                services: [],
                addService() {
                    this.services.push({
                        id: '',
                        quantity: 1
                    });
                },
                removeService(index) {
                    this.services.splice(index, 1);
                },
                calculateSubtotal(item) {
                    if (!item.id || !item.quantity) return 0;
                    const service = document.querySelector(`option[value="${item.id}"]`);
                    if (!service) return 0;
                    const price = service.dataset.price;
                    return price * item.quantity;
                },
                calculateTotal() {
                    return this.services.reduce((total, item) => total + this.calculateSubtotal(item), 0);
                },
                formatPrice(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                }
            }
        }
    </script>
    @endpush
</x-app-layout> 