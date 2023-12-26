<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::middleware('admin')->prefix('admin')->group(function() {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index']);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
    Route::resource('supplier', \App\Http\Controllers\Admin\SupplierController::class);
    Route::resource('pemasukan', \App\Http\Controllers\Admin\PemasukanController::class);
    Route::resource('pengeluaran', \App\Http\Controllers\Admin\PengeluaranController::class);
    Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
    Route::post('stok/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'stok']);
    Route::get('pemasukan', [\App\Http\Controllers\Admin\PemasukanController::class, 'index']);
    Route::get('pengeluaran', [\App\Http\Controllers\Admin\PengeluaranController::class, 'index']);
    Route::get('laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index']);
    Route::get('pemasukan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PemasukanController::class, 'cetakpdf']);
    Route::get('pengeluaran/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengeluaranController::class, 'cetakpdf']);
});


Route::middleware('sales')->prefix('sales')->group(function() {
    Route::get('/', [\App\Http\Controllers\Sales\HomeController::class, 'index']);
});