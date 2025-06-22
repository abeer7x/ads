<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/registerAdmin', [AuthController::class, 'register'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('reviews', ReviewController::class);
        Route::apiResource('ads', AdController::class)->except(['index', 'show']);
Route::post('ads/{ad}/approve', [AdController::class, 'approve']);

    Route::post('ads/{ad}/reject', [AdController::class, 'reject']);
    Route::apiResource('categories', CategoryController::class);
    
});
Route::get('/ads', [AdController::class, 'index']);
Route::get('/ads/{ad}', [AdController::class, 'show']);
