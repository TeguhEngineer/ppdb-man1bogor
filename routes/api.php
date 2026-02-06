<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProdukController;

// API V1 Routes
Route::prefix('v1')->name('api.v1.')->group(function () {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'user'])->name('user');
        
        // User routes (admin only)
        Route::middleware('admin')->group(function () {
            Route::apiResource('users', UserController::class);
        });
        
        // Produk routes (operator & admin)
        Route::middleware('operator')->group(function () {
            Route::apiResource('produk', ProdukController::class);
        });
    });
});
