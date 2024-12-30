<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold">Create an Account</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Join us and experience the best laundry service</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4 mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>

            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">Sign in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
