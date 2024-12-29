<x-admin-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ isset($user) ? 'Edit an existing user\'s details.' : 'Add a new user to the system.' }}</p>
        </div>
    </div>

    <div class="mt-8">
        <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Personal Information</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">User's personal and contact information.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">{{ old('address', $user->address ?? '') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Account Details</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">User's role, branch, and account settings.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                <select id="role_id" name="role_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Branch</label>
                                <select id="branch_id" name="branch_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 bg-white dark:bg-gray-800 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="">No Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(!isset($user))
                            <div class="col-span-6 sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                <input type="password" name="password" id="password" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                            </div>
                            @endif

                            <div class="col-span-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }} class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 dark:border-gray-600 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700 dark:text-gray-300">Active Account</label>
                                        <p class="text-gray-500 dark:text-gray-400">Active accounts can log in and use the system.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Additional Contact</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional contact methods for notifications.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="telegram_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telegram ID</label>
                                <input type="text" name="telegram_id" id="telegram_id" value="{{ old('telegram_id', $user->telegram_id ?? '') }}" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                @error('telegram_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">WhatsApp</label>
                                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $user->whatsapp ?? '') }}" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                @error('whatsapp')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Cancel
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    {{ isset($user) ? 'Update User' : 'Create User' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout> 