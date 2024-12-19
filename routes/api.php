<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterDataProductController;
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
    Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
    Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);
});

Route::resource('verification-pdf', VerificationPDFController::class)
    ->middleware('auth:sanctum');

Route::resource('verification-token', VerificationTokenController::class)
    ->middleware('auth:sanctum');

Route::resource('master-data-product', MasterDataProductController::class)
    ->middleware('auth:sanctum');
