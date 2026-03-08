<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CarImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// CRUD 1: Coches (Público) - Solo lectura
Route::apiResource('cars', CarController::class, [
    'only' => ['index', 'show'],
]);

// CRUD 2: Imágenes de Coches (Autenticado con Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('car-images', CarImageController::class);
    
    // Rutas adicionales para imágenes
    Route::get('cars/{car}/images', [CarImageController::class, 'carImages']);
    Route::post('cars/{car}/images', [CarImageController::class, 'storeForCar']);
    Route::delete('images/{image}', [CarImageController::class, 'destroy']);
});

// Ruta para obtener el token de autenticación
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
