<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware('auth')
    ->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');