<?php

use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\CustomerController;
use App\Http\Controllers\Employee\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('employee.dashboard');
    
    // Customer Management
    Route::resource('customers', CustomerController::class)->names('employee.customers');
    
    // Transaction Management
    Route::resource('transactions', TransactionController::class)->names('employee.transactions');
    Route::post('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])
        ->name('employee.transactions.status');
    Route::post('/transactions/{transaction}/payment', [TransactionController::class, 'updatePayment'])
        ->name('employee.transactions.payment');
}); 