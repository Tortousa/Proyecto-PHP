<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es'])) {
        Session::put('locale', $locale);
    }
    return back();
})->name('lang.switch');

Route::get('/dashboard', function () {
    // Mostrar anuncios genéricos (coches publicados de otros usuarios)
    $featuredCars = \App\Models\Car::where('published_at', '!=', null)
        ->where('user_id', '!=', Auth::id())
        ->with(['maker', 'model', 'primaryImage', 'city'])
        ->inRandomOrder()
        ->limit(6)
        ->get();

    return view('dashboard', compact('featuredCars'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas privadas
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cars', CarController::class);
});

require __DIR__.'/auth.php';
