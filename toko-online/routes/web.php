<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RiwayatController;

Route::get('/', [ProductController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::post('/keranjang/tambah/{product}', [ProductController::class, 'addToCart'])
    ->middleware('auth')
    ->name('cart.add');

Route::get('/keranjang', [ProductController::class, 'cart'])
    ->middleware('auth')
    ->name('cart.index');

Route::post('/keranjang/tambah-jumlah/{product}', [ProductController::class, 'increase'])
    ->middleware('auth')
    ->name('cart.increase');

Route::post('/keranjang/kurangi/{product}', [ProductController::class, 'decrease'])
    ->middleware('auth')
    ->name('cart.decrease');

Route::post('/keranjang/hapus/{product}', [ProductController::class, 'remove'])
    ->middleware('auth')
    ->name('cart.remove');

Route::post('/keranjang/kosongkan', [ProductController::class, 'clearCart'])
    ->middleware('auth')
    ->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware('auth')
    ->name('checkout.index');

Route::post('/checkout', [CheckoutController::class, 'process'])
    ->middleware('auth')
    ->name('checkout.process');

Route::get('/riwayat', [RiwayatController::class, 'index'])
    ->middleware('auth')
    ->name('riwayat.index');