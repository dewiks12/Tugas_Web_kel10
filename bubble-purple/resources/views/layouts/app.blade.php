<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bubble Purple Laundry') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-full">
            <!-- Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex flex-shrink-0 items-center">
                                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-primary-600">
                                    Bubble Purple
                                </a>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Dashboard</a>
                                    <a href="{{ route('admin.users.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Users</a>
                                    <a href="{{ route('admin.services.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Services</a>
                                @elseif(auth()->user()->isEmployee())
                                    <a href="{{ route('employee.dashboard') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Dashboard</a>
                                    <a href="{{ route('employee.transactions.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Orders</a>
                                    <a href="{{ route('employee.customers.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Customers</a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Dashboard</a>
                                    <a href="{{ route('customer.transactions.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">My Orders</a>
                                @endif
                            @endauth
                        </div>

                        <div class="flex items-center">
                            <!-- Theme Toggle -->
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

                            @auth
                                <!-- Profile Dropdown -->
                                <div class="ml-3 relative" x-data="{ open: false }">
                                    <button 
                                        @click="open = !open"
                                        class="flex items-center gap-x-2 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    >
                                        <span class="text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="">
                                    </button>

                                    <div 
                                        x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    >
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600">Login</a>
                                    <a href="{{ route('register') }}" class="btn-primary">Register</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                    @if (isset($header))
                        <header class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $header }}
                            </h1>
                        </header>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Notification Container -->
        <div id="notification-container" class="fixed top-4 right-4 z-50"></div>
    </body>
</html>
