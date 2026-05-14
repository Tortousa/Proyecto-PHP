<?php

// Tests del dashboard principal.
// Verifica que usuarios autenticados pueden ver el dashboard
// y que los no autenticados son redirigidos al login.

use App\Models\User;
use Illuminate\Support\Facades\Event;

test('el dashboard se muestra para usuarios autenticados', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get('/dashboard')
         ->assertStatus(200);
});

test('el dashboard redirige al login si no estás autenticado', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('el dashboard filtra por marca', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
         ->get('/dashboard?maker=Toyota')
         ->assertStatus(200);
});

test('el dashboard filtra por rango de precio', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
         ->get('/dashboard?min_price=5000&max_price=30000')
         ->assertStatus(200);
});

test('el dashboard filtra por tipo de combustible', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
         ->get('/dashboard?fuel_type=1')
         ->assertStatus(200);
});
