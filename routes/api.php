<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/cars',       [CarController::class, 'index']);
Route::get('/cars/{car}', [CarController::class, 'show']);

// Catálogo de datos de referencia (sin autenticación)
Route::prefix('catalog')->group(function () {
    Route::get('/makers',     [CatalogController::class, 'makers']);
    Route::get('/fuel-types', [CatalogController::class, 'fuelTypes']);
    Route::get('/car-types',  [CatalogController::class, 'carTypes']);
});

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/me',         [UserController::class, 'me']);
    Route::get('/user/favourites', [UserController::class, 'favourites']);

    Route::post('/cars',            [CarController::class, 'store']);
    Route::put('/cars/{car}',       [CarController::class, 'update']);
    Route::delete('/cars/{car}',    [CarController::class, 'destroy']);

    Route::post('/cars/{car}/favourite', [FavouriteController::class, 'toggle']);
});

// Auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'user']);
    });
});
