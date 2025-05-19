<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResources(
        [
            'products' => ProductController::class,
            'orders' => OrderController::class,
        ]
    );
});
