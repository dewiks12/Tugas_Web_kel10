<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold">Welcome Back</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Please sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-purple-600 shadow-sm focus:ring-purple-500 dark:focus:ring-purple-600" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col gap-4 mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Sign in') }}
            </x-primary-button>

            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">Sign up</a>
            </p>
        </div>
    </form>
</x-guest-layout>
