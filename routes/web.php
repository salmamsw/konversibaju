<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonversiBajuController;

Route::get('/', [KonversiBajuController::class, 'index'])->name('konversi.index');

// Produk
Route::post('/produk', [KonversiBajuController::class, 'storeProduk'])->name('produk.store');
Route::put('/produk/{id}', [KonversiBajuController::class, 'updateProduk'])->name('produk.update');
Route::delete('/produk/{id}', [KonversiBajuController::class, 'destroyProduk'])->name('produk.destroy');

// Atribut
Route::post('/bahan', [KonversiBajuController::class, 'storeBahan'])->name('bahan.store');
Route::put('/bahan/{id}', [KonversiBajuController::class, 'updateBahan'])->name('bahan.update');
Route::delete('/bahan/{id}', [KonversiBajuController::class, 'destroyBahan'])->name('bahan.destroy');

// Konversi
Route::post('/konversi', [KonversiBajuController::class, 'konversi'])->name('konversi.proses');