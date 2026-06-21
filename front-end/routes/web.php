<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\Admin\DashboardController;
use App\Http\Controllers\Frontend\Admin\ProductController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index']);

// Autentikasi
Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/set-session', [AuthController::class, 'setSession']); // Route baru

// Keranjang
Route::get('/cart', [CartController::class, 'index']);

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
});
