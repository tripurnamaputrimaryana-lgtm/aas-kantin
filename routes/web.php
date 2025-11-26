<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('kategori', KategoriController::class);
Route::resource('produk', ProdukController::class);
Route::resource('transaksi', TransaksiController::class);

//test template
Route::get('template', function() {
    return view('layouts.dashboard');
});

Route::get('/dashboard1', function () {
    return view('includes.dashboard1');
})->name('dashboard');

