<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Custom Styles -->
        <style>
            body {
                background-color: #f8f9fa;
            }
            .navbar {
                box-shadow: 0 2px 4px rgba(0,0,0,.1);
            }
            .card {
                box-shadow: 0 1px 3px rgba(0,0,0,.1);
            }
            .navbar-brand {
                font-weight: 600;
                font-size: 1.5rem;
                color: #6f42c1 !important;
            }
            .nav-link {
                font-weight: 500;
                padding: 0.5rem 1rem !important;
                border-radius: 0.375rem;
                transition: all 0.2s;
            }
            .nav-link:hover {
                background-color: rgba(111, 66, 193, 0.1);
            }
            .nav-link.active {
                background-color: #6f42c1;
                color: white !important;
            }
            .dropdown-item:active {
                background-color: #6f42c1;
            }
            .navbar-dark {
                background-color: #2d2d2d !important;
            }
            .notification-badge {
                position: absolute;
                top: 0;
                right: 0;
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                line-height: 1;
                border-radius: 0.375rem;
            }
        </style>

        @stack('scripts')
    </head>
    <body>
        <div class="min-vh-100">
            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <!-- Brand -->
                    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                        <i class="bi bi-droplet-fill me-2"></i>
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <!-- Mobile Toggle -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Main Navigation -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <!-- Admin Navigation -->
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                                           href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.customers.index') }}">
                                            <i class="bi bi-people me-1"></i> Customers
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.services.index') }}">
                                            <i class="bi bi-box-seam me-1"></i> Services
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.branches.index') }}">
                                            <i class="bi bi-shop me-1"></i> Branches
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}" 
                                           href="{{ route('admin.transactions.index') }}">
                                            <i class="bi bi-receipt me-1"></i> Transactions
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->isEmployee())
                                    <!-- Employee Navigation -->
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" 
                                           href="{{ route('employee.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('employee.orders.*') ? 'active' : '' }}" 
                                           href="{{ route('employee.orders.create') }}">
                                            <i class="bi bi-plus-circle me-1"></i> New Order
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('employee.transactions.*') ? 'active' : '' }}" 
                                           href="{{ route('employee.transactions.index') }}">
                                            <i class="bi bi-receipt me-1"></i> Transactions
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </ul>

                        <!-- Right Side Navigation -->
                        <ul class="navbar-nav ms-auto">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i> Register
                                    </a>
                                </li>
                            @else
                                <!-- Notifications -->
                                <li class="nav-item me-3">
                                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-bell fs-5"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            3
                                            <span class="visually-hidden">unread notifications</span>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <h6 class="dropdown-header">Notifications</h6>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="bi bi-receipt text-primary"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="mb-0">New order received</p>
                                                    <small class="text-muted">3 minutes ago</small>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-center" href="#">View all notifications</a>
                                    </div>
                                </li>

                                <!-- User Menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-person-circle fs-5 me-2"></i>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="bi bi-person me-2"></i> Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-4">
                @if(session('success'))
                    <div class="container">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="container">
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
