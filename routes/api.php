<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizationController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/organizations', [OrganizationController::class, 'index']);
Route::get('/organizations/{id}', [OrganizationController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::post('/organizations', [OrganizationController::class, 'store']);
        Route::delete('/organizations/{id}', [OrganizationController::class, 'destroy']);
    });

    // Admin & Daerah routes (restrictions in controller)
    Route::put('/organizations/{id}', [OrganizationController::class, 'update']);
});
