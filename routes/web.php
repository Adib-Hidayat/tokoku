<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/finance-login', [AuthController::class, 'financeLogin'])->name('finance.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Produk
    Route::resource('products', ProductController::class);

    // Transaksi
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update']);
    Route::delete('transactions/{transaction}/force-delete', [TransactionController::class, 'forceDelete'])->name('transactions.forceDelete');

    // Stok Gudang
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
    Route::post('/stock/restock', [StockController::class, 'restock'])->name('stock.restock');

    // Manajemen User
    Route::resource('users', UserController::class)->except(['show']);

    // --- MODUL KEUANGAN ---
    Route::middleware(['role:owner,admin'])->group(function () {
        Route::get('/finance/dashboard', [FinanceController::class, 'dashboard'])->name('finance.dashboard');
        Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
        Route::post('/finance', [FinanceController::class, 'store'])->name('finance.store');
        Route::delete('/finance/{finance}', [FinanceController::class, 'destroy'])->name('finance.destroy');

        Route::get('/debts', [DebtController::class, 'index'])->name('debts.index');
        Route::post('/debts', [DebtController::class, 'store'])->name('debts.store');
        Route::post('/debts/{debt}/pay', [DebtController::class, 'pay'])->name('debts.pay');
        Route::delete('/debts/{debt}', [DebtController::class, 'destroy'])->name('debts.destroy');

        Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit_loss');
        Route::get('/reports/cash-flow', [ReportController::class, 'cashFlow'])->name('reports.cash_flow');
    });
});
