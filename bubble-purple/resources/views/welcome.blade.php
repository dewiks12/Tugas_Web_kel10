<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Bubble Purple') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-gray-900">
        <!-- Bubble Animation -->
        <x-bubbles />

        <div class="flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white/80 dark:bg-gray-900/90 backdrop-blur-lg border-b border-purple-100 dark:border-purple-900/10 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('welcome') }}" class="flex items-center space-x-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-purple-400 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-purple-600 dark:text-purple-400">Bubble Purple</span>
                            </a>
                        </div>
                        <div class="flex items-center space-x-6">
                            <button onclick="toggleTheme()" class="p-2 text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200">
                                <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                            @if (Route::has('login'))
                                <div class="flex items-center space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">Login</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 dark:hover:bg-purple-400 focus:bg-purple-500 dark:focus:bg-purple-400 active:bg-purple-700 dark:active:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-grow">
                <!-- Hero Section -->
                <div class="relative isolate px-6 py-24 sm:py-32 lg:py-40">
                    <div class="mx-auto max-w-4xl text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl scale-in">
                            Professional Laundry Service
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300 fade-in max-w-2xl mx-auto">
                            Experience the best laundry service in town. We offer professional washing, drying, and ironing services with free pickup and delivery.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6 slide-in">
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 dark:bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 dark:hover:bg-purple-400 focus:bg-purple-500 dark:focus:bg-purple-400 active:bg-purple-700 dark:active:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Get Started
                            </a>
                            <a href="#services" class="text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">
                                Learn more →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Services Section -->
                <div id="services" class="py-24 bg-gray-900">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center mb-16">
                            <h2 class="text-3xl font-bold text-white mb-4">Our Services</h2>
                            <p class="mt-6 text-lg leading-8 text-white">
                                We provide comprehensive laundry services to keep your clothes fresh, clean, and 
                                <span class="text-purple-400">well-maintained</span>.
                            </p>
                            <p class="mt-2 text-sm text-purple-400 italic">Quality service for your precious garments</p>
                        </div>
                        
                        <div class="mx-auto max-w-5xl">
                            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                <!-- Wash & Fold -->
                                <div class="text-center">
                                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" viewBox="0 0 24 24">
                                            <path fill="#A78BFA" d="M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-purple-400 mb-4">Wash & Fold</h3>
                                    <p class="text-white text-lg">
                                        Professional washing and folding service for all your everyday clothes.
                                    </p>
                                </div>

                                <!-- Dry Cleaning -->
                                <div class="text-center">
                                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" viewBox="0 0 24 24">
                                            <path fill="#A78BFA" d="M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-purple-400 mb-4">Dry Cleaning</h3>
                                    <p class="text-white text-lg">
                                        Expert dry cleaning for your delicate and special care garments.
                                    </p>
                                </div>

                                <!-- Ironing & Pressing -->
                                <div class="text-center">
                                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" viewBox="0 0 24 24">
                                            <path fill="#A78BFA" d="M13 3l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-purple-400 mb-4">Ironing & Pressing</h3>
                                    <p class="text-white text-lg">
                                        Professional ironing and pressing service for a crisp, polished look.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 border-t border-purple-900/10">
                <div class="mx-auto max-w-7xl px-6 py-8">
                    <p class="text-center text-sm text-gray-400">
                        © {{ date('Y') }} Bubble Purple. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>

        <script>
            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            }

            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </body>
</html>
