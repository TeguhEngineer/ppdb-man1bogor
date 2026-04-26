<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\BerkasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('biodata', BiodataController::class);
    Route::resource('berkas', BerkasController::class);
    Route::get('pengumuman', [App\Http\Controllers\PengumumanController::class, 'index'])->name('pengumuman.index');
    
    // Profile routes (all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin routes
    Route::prefix('admin')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('admin.verifikasi.index');
        Route::get('/verifikasi/{pendaftaran}', [App\Http\Controllers\Admin\VerifikasiController::class, 'show'])->name('admin.verifikasi.show');
        Route::put('/verifikasi/{pendaftaran}/status', [App\Http\Controllers\Admin\VerifikasiController::class, 'updateStatus'])->name('admin.verifikasi.update');
        
        Route::resource('pengumuman', App\Http\Controllers\Admin\PengumumanController::class)->names([
            'index' => 'admin.pengumuman.index',
            'create' => 'admin.pengumuman.create',
            'store' => 'admin.pengumuman.store',
            'destroy' => 'admin.pengumuman.destroy',
        ])->except(['show', 'edit', 'update']);
    });
});

require __DIR__ . '/auth.php';
