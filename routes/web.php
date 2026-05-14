<?php

// Rutas web del proyecto Segunda Marcha.
// Cada ruta apunta a un controlador — aquí no hay lógica de negocio.

use App\Http\Controllers\Web\CarController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LocaleController;
use App\Http\Controllers\Web\PdfController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════════════
// PÚBLICAS — accesibles sin autenticación
// GET  /                   → home con listado de coches publicados
// GET  /cars/{car}         → detalle de un coche
// GET  /lang/{locale}      → cambia el idioma de la sesión (es / en)
// ═══════════════════════════════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');
// whereNumber evita que /cars/create o /cars/edit coincidan con esta ruta
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show')->whereNumber('car');
Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

// ═══════════════════════════════════════════════════════════════
// AUTENTICADO + EMAIL VERIFICADO
// GET  /dashboard          → panel con anuncios de otros usuarios
// ═══════════════════════════════════════════════════════════════

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ═══════════════════════════════════════════════════════════════
// AUTENTICADO — cualquier usuario con sesión activa
// GET    /profile/me       → resumen del perfil propio
// GET    /profile          → formulario de edición del perfil
// PATCH  /profile          → guarda cambios del perfil
// DELETE /profile          → elimina la cuenta propia
// GET    /cars/create      → formulario nuevo anuncio
// POST   /cars             → guarda nuevo anuncio
// GET    /cars/{car}/edit  → formulario editar anuncio (CarPolicy)
// PUT    /cars/{car}       → guarda cambios del anuncio (CarPolicy)
// DELETE /cars/{car}       → elimina anuncio (CarPolicy)
// GET    /cars/{car}/pdf   → descarga ficha del coche en PDF
// ═══════════════════════════════════════════════════════════════

Route::middleware('auth')->group(function () {
    // Perfil propio del usuario
    Route::get('/profile/me', [ProfileController::class, 'me'])->name('profile.me');
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de anuncios — show ya está definido como ruta pública
    Route::resource('cars', CarController::class)->except(['show']);

    // Ficha del coche en PDF
    Route::get('/cars/{car}/pdf', [PdfController::class, 'carDetail'])->name('cars.pdf');
});

// ═══════════════════════════════════════════════════════════════
// SOLO ADMINISTRADOR — middleware rol:admin
// Prefijo /admin, nombres admin.*
// GET    /admin/users             → listado de todos los usuarios
// GET    /admin/users/{user}      → detalle de un usuario
// GET    /admin/users/{user}/edit → formulario editar usuario
// PUT    /admin/users/{user}      → guarda cambios del usuario
// DELETE /admin/users/{user}      → elimina usuario (UserPolicy)
// GET    /admin/cars/report/pdf   → informe PDF de todos los coches
// ═══════════════════════════════════════════════════════════════

Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de usuarios — create/store no están: los usuarios se registran solos
    Route::resource('users', UserController::class)->except(['create', 'store']);

    // Informe completo del sistema en PDF
    Route::get('/cars/report/pdf', [PdfController::class, 'carsReport'])->name('cars.report.pdf');
});

require __DIR__.'/auth.php';