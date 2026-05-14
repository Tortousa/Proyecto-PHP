<?php

use App\Http\Controllers\Web\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Web\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Web\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Web\Auth\NewPasswordController;
use App\Http\Controllers\Web\Auth\PasswordController;
use App\Http\Controllers\Web\Auth\PasswordResetLinkController;
use App\Http\Controllers\Web\Auth\RegisteredUserController;
use App\Http\Controllers\Web\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════════════
// INVITADOS — solo accesibles si NO hay sesión activa (middleware guest)
// Si un usuario autenticado intenta entrar aquí, Laravel lo redirige a /home
// GET  /register                → formulario de registro
// POST /register                → crea la cuenta y redirige
// GET  /login                   → formulario de login
// POST /login                   → valida credenciales y crea sesión
// GET  /forgot-password         → formulario para solicitar reset de contraseña
// POST /forgot-password         → envía el email con el enlace de reset
// GET  /reset-password/{token}  → formulario para introducir la nueva contraseña
// POST /reset-password          → guarda la nueva contraseña y redirige
// ═══════════════════════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('register',  [RegisteredUserController::class, 'create'])->name('register'); // Formulario
    Route::post('register', [RegisteredUserController::class, 'store']);                    // Guardar cuenta

    Route::get('login',  [AuthenticatedSessionController::class, 'create'])->name('login'); // Formulario
    Route::post('login', [AuthenticatedSessionController::class, 'store']);                 // Iniciar sesión

    Route::get('forgot-password',  [PasswordResetLinkController::class, 'create'])->name('password.request'); // Formulario
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');    // Enviar email

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset'); // Formulario
    Route::post('reset-password',        [NewPasswordController::class, 'store'])->name('password.store');  // Guardar
});

// ═══════════════════════════════════════════════════════════════
// AUTENTICADO — solo accesibles con sesión activa
// GET  /verify-email                      → aviso de verificación pendiente
// GET  /verify-email/{id}/{hash}          → confirma el email con enlace firmado
// POST /email/verification-notification   → reenvía el email de verificación
// GET  /confirm-password                  → pide confirmar contraseña antes de acción sensible
// POST /confirm-password                  → valida la confirmación
// PUT  /password                          → cambia la contraseña desde el perfil
// POST /logout                            → cierra sesión y destruye el token CSRF
// ═══════════════════════════════════════════════════════════════

Route::middleware('auth')->group(function () {
    // Verificación de email
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice'); // Pantalla aviso

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)  // Enlace del email
        ->middleware(['signed', 'throttle:6,1'])                           // signed: enlace no manipulado
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')                                       // throttle: máx 6 reenvíos por minuto
        ->name('verification.send');

    // Confirmación de contraseña (antes de acciones sensibles como borrar cuenta)
    Route::get('confirm-password',  [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Cambio de contraseña desde el perfil
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Cerrar sesión
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

