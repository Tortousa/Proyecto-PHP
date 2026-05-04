<?php

// Tests del dashboard principal.
// Verifica que usuarios autenticados pueden ver el dashboard
// y que los no autenticados son redirigidos al login.

use App\Models\User;

test('el dashboard se muestra para usuarios autenticados', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get('/dashboard')
         ->assertStatus(200);
});

test('el dashboard redirige al login si no estás autenticado', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});
