<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// All app routes require login
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('stock-in', StockInController::class);
    Route::resource('stock-out', StockOutController::class);
    Route::resource('stocks', StocksController::class)->only(['index', 'edit', 'update']);
    Route::get('reports/stock-summary', [ReportController::class, 'stockSummary'])->name('reports.stock-summary');
    Route::get('reports/stock-in-report', [ReportController::class, 'stockInReport'])->name('reports.stock-in-report');

    // Admin only
    Route::middleware('admin')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('accounts', AccountController::class);
    });
});