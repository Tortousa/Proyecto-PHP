<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════════════
// AUTH PÚBLICO — punto de entrada a la API (no requiere token)
// POST /api/auth/register  → crea cuenta y devuelve token
// POST /api/auth/login     → valida credenciales y devuelve token
// ═══════════════════════════════════════════════════════════════

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']); // Crea cuenta + token
    Route::post('/login',    [AuthController::class, 'login']);    // Login + token
});

// ═══════════════════════════════════════════════════════════════
// PÚBLICAS — accesibles sin autenticación
// GET /api/cars            → listado paginado con filtros opcionales
// GET /api/cars/{car}      → detalle completo de un coche
// GET /api/catalog/*       → catálogos de referencia (makers, tipos...)
// ═══════════════════════════════════════════════════════════════

Route::get('/cars',       [CarController::class, 'index']); // Listado público
Route::get('/cars/{car}', [CarController::class, 'show']);  // Detalle público

Route::prefix('catalog')->group(function () {
    Route::get('/makers',     [CatalogController::class, 'makers']);     // GET /api/catalog/makers
    Route::get('/fuel-types', [CatalogController::class, 'fuelTypes']); // GET /api/catalog/fuel-types
    Route::get('/car-types',  [CatalogController::class, 'carTypes']);  // GET /api/catalog/car-types
});

// ═══════════════════════════════════════════════════════════════
// PROTEGIDAS — requieren cabecera: Authorization: Bearer <token>
// ═══════════════════════════════════════════════════════════════


// ═══════════════════════════════════════════════════════════════
// SOLO ADMINISTRADOR — requiere token + rol admin
// GET /api/admin/users → listado paginado de todos los usuarios
// ═══════════════════════════════════════════════════════════════

Route::middleware(['auth:sanctum', 'rol:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // GET /api/admin/users
});

Route::middleware('auth:sanctum')->group(function () {

    // ── Auth ────────────────────────────────────────────────────
    // POST /api/auth/logout  → invalida el token actual
    // GET  /api/auth/me      → datos del usuario autenticado
    Route::post('/auth/logout', [AuthController::class, 'logout']); // Cierra sesión
    Route::get('/auth/me',      [AuthController::class, 'user']);   // Perfil propio

    // ── Usuario ─────────────────────────────────────────────────
    // GET /api/user/me          → perfil extendido del usuario
    // GET /api/user/favourites  → coches marcados como favoritos
    Route::get('/user/me',         [UserController::class, 'me']);
    Route::get('/user/favourites', [UserController::class, 'favourites']);

    // ── Coches ──────────────────────────────────────────────────
    // POST   /api/cars          → crea anuncio (cualquier usuario autenticado)
    // PUT    /api/cars/{car}    → edita anuncio (solo dueño o admin — CarPolicy)
    // DELETE /api/cars/{car}    → elimina anuncio (solo dueño o admin — CarPolicy)
    // POST   /api/cars/{car}/favourite → toggle rápido añadir/quitar favorito
    Route::post('/cars',                 [CarController::class, 'store']);
    Route::put('/cars/{car}',            [CarController::class, 'update']);
    Route::delete('/cars/{car}',         [CarController::class, 'destroy']);
    Route::post('/cars/{car}/favourite', [FavouriteController::class, 'toggle']);

    // ── Favoritos (CRUD completo) ────────────────────────────────
    // GET    /api/favourites          → lista todos los favoritos del usuario
    // GET    /api/favourites/{car}    → detalle de un favorito con datos del pivote
    // POST   /api/favourites/{car}    → añade un coche a favoritos (con nota opcional)
    // PUT    /api/favourites/{car}    → actualiza la nota del favorito
    // DELETE /api/favourites/{car}    → elimina un coche de favoritos
    Route::get('/favourites',           [FavouriteController::class, 'index']);
    Route::get('/favourites/{car}',     [FavouriteController::class, 'show']);
    Route::post('/favourites/{car}',    [FavouriteController::class, 'store']);
    Route::put('/favourites/{car}',     [FavouriteController::class, 'update']);
    Route::delete('/favourites/{car}',  [FavouriteController::class, 'destroy']);
});
