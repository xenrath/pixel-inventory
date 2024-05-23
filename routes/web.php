<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index']);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
    Route::resource('supplier', \App\Http\Controllers\Admin\SupplierController::class);
    Route::resource('pemasukan', \App\Http\Controllers\Admin\PemasukanController::class);
    Route::resource('pengeluaran', \App\Http\Controllers\Admin\PengeluaranController::class);
    Route::resource('laporan', \App\Http\Controllers\Admin\LaporanController::class);
    Route::post('stok/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'stok']);

    Route::get('pemasukan/get_item/{id}', [\App\Http\Controllers\Admin\PemasukanController::class, 'get_item']);
    Route::get('pemasukan/delete_item/{id}', [\App\Http\Controllers\Admin\PemasukanController::class, 'delete_item']);
    Route::get('pemasukan', [\App\Http\Controllers\Admin\PemasukanController::class, 'index']);
    
    Route::get('pengeluaran/get_item/{id}', [\App\Http\Controllers\Admin\PengeluaranController::class, 'get_item']);
    Route::get('pengeluaran/delete_item/{id}', [\App\Http\Controllers\Admin\PengeluaranController::class, 'delete_item']);
    Route::get('pengeluaran', [\App\Http\Controllers\Admin\PengeluaranController::class, 'index']);
    
    Route::get('laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index']);
    Route::get('pemasukan/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PemasukanController::class, 'cetakpdf']);
    Route::get('pengeluaran/cetak-pdf/{id}', [\App\Http\Controllers\Admin\PengeluaranController::class, 'cetakpdf']);
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::post('profile/update', [\App\Http\Controllers\Admin\ProfileController::class, 'update']);
    Route::delete('pengeluaran/delete_barang/{id}', [\App\Http\Controllers\Admin\PengeluaranController::class, 'delete_barang']);
});


Route::middleware('sales')->prefix('sales')->group(function () {
    Route::get('/', [\App\Http\Controllers\Sales\HomeController::class, 'index']);
    Route::resource('barang', \App\Http\Controllers\Sales\BarangController::class);
    Route::resource('laporan', \App\Http\Controllers\Sales\LaporanController::class);
    Route::get('laporan', [\App\Http\Controllers\Sales\LaporanController::class, 'index']);
    Route::get('profile', [\App\Http\Controllers\Sales\ProfileController::class, 'index']);
    Route::post('profile/update', [\App\Http\Controllers\Sales\ProfileController::class, 'update']);    Route::get('pemasukan/get_item/{id}', [\App\Http\Controllers\Sales\PemasukanController::class, 'get_item']);
    Route::get('pemasukan/delete_item/{id}', [\App\Http\Controllers\Sales\PemasukanController::class, 'delete_item']);
    Route::get('pemasukan/cetak-pdf/{id}', [\App\Http\Controllers\Sales\PemasukanController::class, 'cetakpdf']);
    Route::resource('pemasukan', \App\Http\Controllers\Sales\PemasukanController::class);
});