<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ isset($service) ? 'Edit Service' : 'Create Service' }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ isset($service) ? 'Edit an existing service in the system.' : 'Add a new service to the system.' }}</p>
        </div>
    </div>

    <div class="mt-8">
        <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($service))
                @method('PUT')
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $service->name ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ old('description', $service->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', $service->price ?? '') }}" class="pl-10 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required min="0" step="0.01">
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700 dark:text-gray-300">Active</label>
                            <p class="text-gray-500 dark:text-gray-400">Set whether this service is active and can be used in transactions.</p>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right sm:px-6 space-x-3">
                    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        {{ isset($service) ? 'Update Service' : 'Create Service' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout> 