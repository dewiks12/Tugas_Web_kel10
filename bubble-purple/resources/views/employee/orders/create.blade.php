<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Create New Order</h2>
            </div>
            <a href="{{ route('employee.transactions.index') }}" class="btn-secondary">
                Back to Orders
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('employee.orders.store') }}" method="POST" class="space-y-6" x-data="orderForm()">
                @csrf
                
                <!-- Customer Selection -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Customer Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Customer</label>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                    <option value="">Select a customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Selection -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Services</h3>
                            <button type="button" @click="addService()" class="btn-secondary">
                                Add Service
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <template x-for="(service, index) in services" :key="index">
                                <div class="grid grid-cols-12 gap-4 items-center">
                                    <div class="col-span-5">
                                        <label :for="'services['+index+'][id]'" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service</label>
                                        <select :name="'services['+index+'][id]'" :id="'services['+index+'][id]'" 
                                                @change="updatePrice(index, $event.target.value)"
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                            <option value="">Select a service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-3">
                                        <label :for="'services['+index+'][quantity]'" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                        <input type="number" :name="'services['+index+'][quantity]'" :id="'services['+index+'][quantity]'" 
                                               x-model="service.quantity" @input="calculateSubtotal(index)"
                                               class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subtotal</label>
                                        <p class="mt-2 text-sm text-gray-900 dark:text-gray-100" x-text="'Rp ' + numberFormat(service.subtotal)"></p>
                                    </div>
                                    <div class="col-span-1">
                                        <button type="button" @click="removeService(index)" class="mt-6 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <div class="text-right">
                                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Total: Rp <span x-text="numberFormat(total)"></span>
                                </p>
                            </div>

                            @error('services')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-purple-900 dark:text-purple-100">Additional Notes</h3>
                    </div>
                    <div class="card-body">
                        <textarea name="notes" id="notes" rows="3" 
                                  class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                  placeholder="Add any special instructions or notes here">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('employee.transactions.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Create Order</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function orderForm() {
            return {
                services: [],
                total: 0,
                
                addService() {
                    this.services.push({
                        id: '',
                        quantity: 1,
                        price: 0,
                        subtotal: 0
                    });
                },
                
                removeService(index) {
                    this.services.splice(index, 1);
                    this.calculateTotal();
                },
                
                updatePrice(index, serviceId) {
                    const option = document.querySelector(`option[value="${serviceId}"]`);
                    if (option) {
                        this.services[index].price = parseFloat(option.dataset.price);
                        this.calculateSubtotal(index);
                    }
                },
                
                calculateSubtotal(index) {
                    const service = this.services[index];
                    service.subtotal = service.price * service.quantity;
                    this.calculateTotal();
                },
                
                calculateTotal() {
                    this.total = this.services.reduce((sum, service) => sum + service.subtotal, 0);
                },
                
                numberFormat(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                }
            }
        }
    </script>
    @endpush
</x-app-layout> 