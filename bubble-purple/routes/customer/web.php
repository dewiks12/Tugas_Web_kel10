<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    
    // Transaction History
    Route::get('/transactions', [TransactionController::class, 'index'])->name('customer.transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('customer.transactions.show');
}); 