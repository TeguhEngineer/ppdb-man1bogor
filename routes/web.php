<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KartuUjianController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\BerkasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jalurs = \App\Models\Jalur::withCount('pendaftarans')->get();
    return view('welcome', compact('jalurs'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/pendaftaran/cetak', [DashboardController::class, 'cetakFormulir'])
    ->middleware(['auth'])
    ->name('pendaftaran.cetak');

Route::get('/kartu-ujian/cetak', [KartuUjianController::class, 'cetakPeserta'])
    ->middleware(['auth'])
    ->name('kartu-ujian.cetak');

Route::middleware('auth')->group(function () {
    Route::resource('biodata', BiodataController::class);
    Route::post('berkas/{berka}/ajukan-ulang', [BerkasController::class, 'ajukanUlang'])->name('berkas.ajukan-ulang');
    Route::resource('berkas', BerkasController::class);
    Route::get('pengumuman', [App\Http\Controllers\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('pengumuman/{id}/dibaca', [App\Http\Controllers\PengumumanController::class, 'tandaiDibaca'])->name('pengumuman.dibaca');
    
    // Profile routes (all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin routes
    Route::prefix('admin')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('admin.verifikasi.index');
        Route::get('/verifikasi/export', [App\Http\Controllers\Admin\VerifikasiController::class, 'export'])->name('admin.verifikasi.export');
        Route::get('/verifikasi/{pendaftaran}', [App\Http\Controllers\Admin\VerifikasiController::class, 'show'])->name('admin.verifikasi.show');
        Route::put('/verifikasi/{pendaftaran}/status', [App\Http\Controllers\Admin\VerifikasiController::class, 'updateStatus'])->name('admin.verifikasi.update');
        Route::post('/verifikasi/{pendaftaran}/berkas-status', [App\Http\Controllers\Admin\VerifikasiController::class, 'updateBerkasStatus'])->name('admin.verifikasi.berkas-status');
        
        // Jalur/Quota routes
        Route::resource('jalur-pendaftaran', App\Http\Controllers\Admin\JalurController::class)->names([
            'index' => 'admin.jalur.index',
            'create' => 'admin.jalur.create',
            'store' => 'admin.jalur.store',
            'edit' => 'admin.jalur.edit',
            'update' => 'admin.jalur.update',
            'destroy' => 'admin.jalur.destroy',
        ])->parameters(['jalur-pendaftaran' => 'jalur'])->except(['show']);

        Route::get('/seleksi-ujian', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'index'])->name('admin.seleksi-ujian.index');
        Route::post('/seleksi-ujian/ruangan', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'storeRuangan'])->name('admin.seleksi-ujian.ruangan.store');
        Route::put('/seleksi-ujian/ruangan/{ruangan}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'updateRuangan'])->name('admin.seleksi-ujian.ruangan.update');
        Route::delete('/seleksi-ujian/ruangan/{ruangan}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'destroyRuangan'])->name('admin.seleksi-ujian.ruangan.destroy');
        Route::post('/seleksi-ujian/mapel', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'storeMapel'])->name('admin.seleksi-ujian.mapel.store');
        Route::put('/seleksi-ujian/mapel/{mapel}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'updateMapel'])->name('admin.seleksi-ujian.mapel.update');
        Route::delete('/seleksi-ujian/mapel/{mapel}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'destroyMapel'])->name('admin.seleksi-ujian.mapel.destroy');
        Route::post('/seleksi-ujian/jadwal', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'storeJadwal'])->name('admin.seleksi-ujian.jadwal.store');
        Route::put('/seleksi-ujian/jadwal/{jadwalUjian}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'updateJadwal'])->name('admin.seleksi-ujian.jadwal.update');
        Route::delete('/seleksi-ujian/jadwal/{jadwalUjian}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'destroyJadwal'])->name('admin.seleksi-ujian.jadwal.destroy');
        Route::put('/seleksi-ujian/kartu/{pendaftaran}', [App\Http\Controllers\Admin\SeleksiUjianController::class, 'updateKartu'])->name('admin.seleksi-ujian.kartu.update');
        Route::get('/seleksi-ujian/kartu/{pendaftaran}/cetak', [KartuUjianController::class, 'cetakAdmin'])->name('admin.seleksi-ujian.kartu.cetak');

        Route::get('/pengumuman/search-participants', [App\Http\Controllers\Admin\PengumumanController::class, 'searchParticipants'])->name('admin.pengumuman.search');
        Route::resource('pengumuman', App\Http\Controllers\Admin\PengumumanController::class)->names([
            'index' => 'admin.pengumuman.index',
            'create' => 'admin.pengumuman.create',
            'store' => 'admin.pengumuman.store',
            'destroy' => 'admin.pengumuman.destroy',
        ])->except(['show', 'edit', 'update']);
    });
});

require __DIR__ . '/auth.php';
