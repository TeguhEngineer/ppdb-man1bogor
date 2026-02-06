<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManajemenController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::get('user/export-xls', [UserManajemenController::class, 'exportExcel'])->name('user.export-xls');
        Route::resource('/user-manajemen', UserManajemenController::class);
    });

    // Operator & Admin routes
    Route::middleware('operator')->group(function () {
        Route::resource('/produk', ProdukController::class);
    });

    // Profile routes (all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
