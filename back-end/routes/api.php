<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    Route::middleware(['role:customer'])->group(function () {
        Route::post('/checkout', [OrderController::class, 'checkout']);
        Route::get('/my-orders', [OrderController::class, 'myOrders']);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::get('/orders', [OrderController::class, 'adminIndex']);
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::get('/sales-report', [OrderController::class, 'salesReport']);
    });
});
