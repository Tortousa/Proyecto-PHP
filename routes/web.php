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

// ── Pública ────────────────────────────────────────────────────────────────────

// Página de inicio con todos los coches publicados (accesible sin login)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cambia el idioma de la sesión (es / en)
Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

// ── Autenticado + email verificado ────────────────────────────────────────────

// Panel principal: muestra anuncios de otros usuarios con filtros
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ── Autenticado ───────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    // Perfil propio del usuario (ver, editar, eliminar cuenta)
    Route::get('/profile/me', [ProfileController::class, 'me'])->name('profile.me');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD completo de anuncios de coches
    Route::resource('cars', CarController::class);

    // Descarga la ficha de un coche en PDF
    Route::get('/cars/{car}/pdf', [PdfController::class, 'carDetail'])->name('cars.pdf');
});

// ── Solo administrador ────────────────────────────────────────────────────────11
Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de usuarios (el admin no puede crear usuarios desde aquí — se registran solos)
    Route::resource('users', UserController::class)->except(['create', 'store']);

    // PDF con el informe completo de todos los coches del sistema
    Route::get('/cars/report/pdf', [PdfController::class, 'carsReport'])->name('cars.report.pdf');
});

require __DIR__.'/auth.php';