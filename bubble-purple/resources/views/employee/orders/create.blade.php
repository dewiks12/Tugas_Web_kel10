<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Create New Order</h2>
            </div>
            <a href="{{ route('employee.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('employee.orders.store') }}" class="space-y-6">
                @csrf
                
                <!-- Customer Selection -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-2 text-purple-600 dark:text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h3 class="text-lg font-medium">Customer Information</h3>
                        </div>
                        <div class="mt-4">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Customer</label>
                            <select name="customer_id" id="customer_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                                <option value="">Select a customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} - {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Services Selection -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2 text-purple-600 dark:text-purple-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h3 class="text-lg font-medium">Services</h3>
                            </div>
                        </div>

                        <div class="space-y-4" x-data="{ services: [{ id: '', quantity: 1 }] }">
                            <template x-for="(service, index) in services" :key="index">
                                <div class="flex items-center space-x-4 bg-purple-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <div class="flex-grow">
                                        <label :for="'services['+index+'][id]'" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service Type</label>
                                        <select :name="'services['+index+'][id]'" :id="'services['+index+'][id]'" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                                            <option value="">Select a service</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-32">
                                        <label :for="'services['+index+'][quantity]'" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                        <input type="number" :name="'services['+index+'][quantity]'" :id="'services['+index+'][quantity]'" x-model="service.quantity" min="1" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required>
                                    </div>
                                    <div class="flex items-end pb-1">
                                        <button type="button" @click="services = services.filter((s, i) => i !== index)" x-show="services.length > 1" class="inline-flex items-center p-2 border border-transparent rounded-full text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click="services.push({ id: '', quantity: 1 })" class="w-full py-3 border-2 border-dashed border-purple-300 dark:border-purple-700 rounded-lg text-purple-600 dark:text-purple-400 hover:border-purple-400 dark:hover:border-purple-600 hover:text-purple-700 dark:hover:text-purple-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Another Service
                                </div>
                            </button>

                            @error('services')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center space-x-2 text-purple-600 dark:text-purple-400 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <h3 class="text-lg font-medium">Additional Notes</h3>
                        </div>
                        <textarea name="notes" id="notes" rows="3" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Add any special instructions or notes here">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('employee.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 dark:hover:bg-purple-400 focus:bg-purple-500 dark:focus:bg-purple-400 active:bg-purple-600 dark:active:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 