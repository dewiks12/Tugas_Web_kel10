<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Create an Account
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Join us and experience the best laundry service
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input" />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-input" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="form-input" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-input" />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full btn-primary">
                        Register
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-500">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
