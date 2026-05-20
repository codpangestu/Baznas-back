<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\DaerahController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/organizations', [OrganizationController::class, 'index']);
Route::get('/organizations/{id}', [OrganizationController::class, 'show']);
Route::get('/provinces', [ProvinceController::class, 'index']);
Route::get('/provinces/{slug}', [ProvinceController::class, 'show']);
Route::get('/daerahs', [DaerahController::class, 'index']);
Route::get('/daerahs/{slug}', [DaerahController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::post('/organizations', [OrganizationController::class, 'store']);
        Route::delete('/organizations/{id}', [OrganizationController::class, 'destroy']);

        // Province Admin CRUD
        Route::post('/provinces', [ProvinceController::class, 'store']);
        Route::put('/provinces/{id}', [ProvinceController::class, 'update']);
        Route::delete('/provinces/{id}', [ProvinceController::class, 'destroy']);

        // Daerah Admin CRUD
        Route::post('/daerahs', [DaerahController::class, 'store']);
        Route::put('/daerahs/{id}', [DaerahController::class, 'update']);
        Route::delete('/daerahs/{id}', [DaerahController::class, 'destroy']);
    });

    // Admin & Daerah routes (restrictions in controller)
    Route::put('/organizations/{id}', [OrganizationController::class, 'update']);
});

