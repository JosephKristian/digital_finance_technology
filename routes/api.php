<?php
use App\Http\Controllers\Api\AuthController;
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

