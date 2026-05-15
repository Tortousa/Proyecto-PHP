<?php

// Tests del cambio de idioma (LocaleController) y del middleware SetLocale.
// Verifican que el idioma se guarda en sesión y se aplica en cada petición.

use Illuminate\Support\Facades\App;

test('se puede cambiar el idioma a español', function () {
    $this->get(route('lang.switch', ['locale' => 'es']))
         ->assertRedirect();

    expect(session('locale'))->toBe('es');
});

test('se puede cambiar el idioma a inglés', function () {
    $this->get(route('lang.switch', ['locale' => 'en']))
         ->assertRedirect();

    expect(session('locale'))->toBe('en');
});

test('un idioma no soportado no se guarda en sesión', function () {
    $this->get(route('lang.switch', ['locale' => 'fr']))
         ->assertNotFound();

    expect(session('locale'))->toBeNull();
});

test('el middleware SetLocale aplica el idioma guardado en sesión', function () {
    $this->withSession(['locale' => 'es'])
         ->get('/')
         ->assertStatus(200);

    expect(App::getLocale())->toBe('es');
});
