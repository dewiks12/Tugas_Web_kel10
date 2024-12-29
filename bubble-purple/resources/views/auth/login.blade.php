<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Welcome Back
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Please sign in to your account
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mt-4 flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-primary-600 hover:text-primary-500" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full btn-primary">
                        Sign in
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-500">
                            Sign up
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
