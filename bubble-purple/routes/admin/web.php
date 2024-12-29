<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management
    Route::resource('users', UserController::class)->names('admin.users');
    
    // Branch Management
    Route::resource('branches', BranchController::class)->names('admin.branches');
    
    // Service Management
    Route::resource('services', ServiceController::class)->names('admin.services');
    
    // Transaction Management
    Route::resource('transactions', TransactionController::class)->names('admin.transactions');
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
}); 