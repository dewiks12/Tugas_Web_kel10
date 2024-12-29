<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\TransactionController as CustomerTransactionController;
use App\Http\Controllers\Employee\CustomerController as EmployeeCustomerController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\TransactionController as EmployeeTransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role->slug === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role->slug === 'employee') {
            return redirect()->route('employee.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Admin Routes
    Route::middleware(['checkRole:admin'])->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::resource('users', UserController::class);
        
        // Branch Management
        Route::resource('branches', BranchController::class);
        
        // Service Management
        Route::resource('services', ServiceController::class);
        
        // Transaction Management
        Route::resource('transactions', AdminTransactionController::class);
        
        // Settings
        Route::resource('settings', SettingController::class)->only(['index', 'store']);
    });

    // Employee Routes
    Route::middleware(['checkRole:employee'])->name('employee.')->prefix('employee')->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
        
        // Customer Management
        Route::resource('customers', EmployeeCustomerController::class);
        
        // Transaction Management
        Route::resource('transactions', EmployeeTransactionController::class);
    });

    // Customer Routes
    Route::middleware(['checkRole:customer'])->name('customer.')->prefix('customer')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        // Transaction History
        Route::resource('transactions', CustomerTransactionController::class)->only(['index', 'show']);
    });
});

require __DIR__.'/auth.php';
