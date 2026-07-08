<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengirimanController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Membutuhkan login untuk semua route ini
Route::middleware('auth')->group(function () {
    
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-based Access Control untuk Data Master
    // Hanya Admin dan Petugas yang bisa mengelola data master
    Route::middleware('role:admin,admin_pusat')->group(function () {
        Route::resource('kategoris', KategoriController::class);
        Route::resource('tokos', TokoController::class);
        Route::resource('armadas', ArmadaController::class);
        Route::resource('barangs', BarangController::class)->except(['index']);
        Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
        Route::resource('penerimaans', App\Http\Controllers\PenerimaanController::class);
        Route::get('/api/oc-rolls/{id}', [App\Http\Controllers\BarangController::class, 'getRollsByOc']);
    });

    // Read access for admin, admin_pusat, admin_toko
    Route::middleware('role:admin,admin_pusat,admin_toko')->group(function () {
        Route::get('barangs', [BarangController::class, 'index'])->name('barangs.index');
        
        Route::get('/laporan-stok', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan-stok/export/excel', [App\Http\Controllers\LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::get('/laporan-stok/export/pdf', [App\Http\Controllers\LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    });

    // Hanya Admin yang bisa mengelola User
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', App\Http\Controllers\UserController::class);
    });

    // Transaksi Pengiriman (Bisa diakses admin, admin_pusat, admin_toko, filter di Controller)
    Route::get('/pengirimans/export/pdf', [App\Http\Controllers\PengirimanController::class, 'exportPdf'])->name('pengirimans.export.pdf');
    Route::get('/pengirimans/export/excel', [App\Http\Controllers\PengirimanController::class, 'exportExcel'])->name('pengirimans.export.excel');
    Route::resource('pengirimans', App\Http\Controllers\PengirimanController::class);
});

require __DIR__.'/auth.php';
