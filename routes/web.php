<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::middleware('admin')->prefix('admin')->group(function() {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index']);
    Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
});

Route::middleware('sales')->prefix('sales')->group(function() {
    Route::get('/', [\App\Http\Controllers\Sales\HomeController::class, 'index']);
});