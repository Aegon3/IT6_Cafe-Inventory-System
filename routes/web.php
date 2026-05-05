<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\ReportController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('stock-in', StockInController::class);
Route::resource('stock-out', StockOutController::class);
Route::resource('stocks', StocksController::class)->only(['index', 'edit', 'update']);
Route::get('reports/stock-summary', [ReportController::class, 'stockSummary'])->name('reports.stock-summary');
Route::get('reports/stock-in-report', [ReportController::class, 'stockInReport'])->name('reports.stock-in-report');