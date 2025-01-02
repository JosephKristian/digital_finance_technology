<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterDataCustomerController;
use App\Http\Controllers\Api\MasterDataProductController;
use App\Http\Controllers\Api\TransactionDetailController;
use App\Http\Controllers\Api\TransactionSaleController;
use App\Http\Controllers\Api\VerificationPDFController;
use App\Http\Controllers\Api\VerificationTokenController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    // Rute logout menggunakan middleware 'auth:sanctum'
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']); // Profil pengguna
        Route::get('/logout', [AuthController::class, 'logout']); // Logout
    });
});

// Protected routes untuk transaksi dan master data
Route::middleware('auth:sanctum')->group(function () {
    // Routes untuk transaksi
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionSaleController::class, 'index']); // Menampilkan daftar transaksi
        Route::get('/payment-method', [TransactionSaleController::class, 'getPaymentMethod']); // Menampilkan daftar transaksi
        Route::get('/check-transaction/{transactibon_id}', [TransactionSaleController::class, 'checkTransactionIdValidPeriod']);
        Route::post('/', [TransactionSaleController::class, 'store']); // Membuat transaksi baru
        Route::post('/{transactionId}/complete', [TransactionSaleController::class, 'markAsCompleted']); // Menyelesaikan transaksi

    });

    // Routes untuk detail transaksi
    Route::prefix('transaction-details')->group(function () {
        Route::get('/{transactionId}', [TransactionDetailController::class, 'index']); // Menampilkan detail transaksi
        Route::get('/total-detail/{transactionId}', [TransactionDetailController::class, 'getDetailTotalByTransactionID']); // Menampilkan detail transaksi
        Route::post('/', [TransactionDetailController::class, 'store']); // Menambahkan detail transaksi
        Route::delete('/{id}', [TransactionDetailController::class, 'destroy']); // Menghapus detail transaksi
    });

    // Routes untuk resource controllers
    Route::resource('verification-pdf', VerificationPDFController::class); // Verifikasi PDF
    Route::resource('verification-token', VerificationTokenController::class); // Verifikasi Token
    Route::resource('master-data-product', MasterDataProductController::class); // Master Data Produk
    Route::resource('master-data-customer', MasterDataCustomerController::class); // Master Data Pelanggan
});
