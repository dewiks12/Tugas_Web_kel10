<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Bubble Purple Laundry') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full bg-gray-100 dark:bg-gray-900">
        <div class="min-h-full">
            <!-- Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex-shrink-0">
                            <span class="text-2xl font-bold text-primary-600">Bubble Purple</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button 
                                onclick="toggleTheme()"
                                class="p-2 text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-500"
                            >
                                <svg class="h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg class="h-6 w-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn-primary">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="relative isolate overflow-hidden">
                <div class="mx-auto max-w-7xl px-6 pt-10 pb-24 sm:pb-32 lg:flex lg:px-8 lg:py-40">
                    <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
                        <h1 class="mt-10 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                            Professional Laundry Service
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                            Experience the best laundry service in town. We offer professional washing, drying, and ironing services with free pickup and delivery.
                        </p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <a href="{{ route('register') }}" class="btn-primary">
                                Get Started
                            </a>
                            <a href="#services" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                                Learn more <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div id="services" class="py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Our Services</h2>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                            We offer a wide range of laundry services to meet your needs
                        </p>
                    </div>
                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                            <!-- Regular Wash -->
                            <div class="card">
                                <div class="card-body">
                                    <dt class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                                        Regular Wash
                                    </dt>
                                    <dd class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Professional washing and drying service for your everyday clothes.
                                    </dd>
                                </div>
                            </div>

                            <!-- Dry Clean -->
                            <div class="card">
                                <div class="card-body">
                                    <dt class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                                        Dry Clean
                                    </dt>
                                    <dd class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Special care for your delicate and formal wear.
                                    </dd>
                                </div>
                            </div>

                            <!-- Express Service -->
                            <div class="card">
                                <div class="card-body">
                                    <dt class="text-lg font-semibold leading-7 text-gray-900 dark:text-white">
                                        Express Service
                                    </dt>
                                    <dd class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">
                                        Same-day service for urgent laundry needs.
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800">
                <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
                    <div class="mt-8 md:order-1 md:mt-0">
                        <p class="text-center text-xs leading-5 text-gray-500 dark:text-gray-400">
                            &copy; {{ date('Y') }} Bubble Purple Laundry. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
