<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OtherTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

// Welcome Route
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Verification
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/umkm', [VerificationController::class, 'umkm'])->name('umkm');
        Route::post('/umkm/pdf', [VerificationController::class, 'verifyWithPDF'])->name('umkm.pdf');
        Route::post('/umkm/token', [VerificationController::class, 'verifyWithToken'])->name('umkm.token');
    });

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Customers
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::patch('/transaction/{transactionId}/completed', [TransactionController::class, 'markAsCompleted'])->name('completed');
        Route::delete('/{id}', [TransactionController::class, 'destroyDetail'])->name('detail-destroy');
    });

    // Others Transactions
    Route::prefix('other-transactions')->name('other.transactions.')->group(function () {
        Route::get('/', [OtherTransactionController::class, 'index'])->name('index');
        Route::post('/create', [OtherTransactionController::class, 'create'])->name('create');
        Route::post('/store', [OtherTransactionController::class, 'store'])->name('store');
        Route::patch('/transaction/{transactionId}/completed', [OtherTransactionController::class, 'markAsCompleted'])->name('completed');
        Route::delete('/{id}', [OtherTransactionController::class, 'destroyDetail'])->name('detail-destroy');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/income-statement', [ReportController::class, 'incomeStatement'])->name('income-statement');
        Route::get('/balance-sheet', [ReportController::class, 'balanceSheet'])->name('balance-sheet');
        Route::get('/sales-report', [ReportController::class, 'salesReport'])->name('sales-report');
    });

    // // Accounting
    // Route::prefix('accounting')->name('accounting.')->group(function () {
    //     Route::get('/general-ledger', [ReportController::class, 'incomeStatement'])->name('general-ledger');
    //     Route::get('/balance-sheet', [ReportController::class, 'balanceSheet'])->name('balance-sheet');
    // });
    
});

require __DIR__ . '/auth.php';
