<?php

// Tests del catálogo público de datos de referencia.
// Estos endpoints son públicos — no requieren autenticación —
// y sirven los datos que necesita el cliente móvil para poblar sus filtros.

use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Maker;

test('el catálogo de marcas devuelve la lista de makers', function () {
    Maker::factory()->count(3)->create();

    $this->getJson('/api/catalog/makers')
         ->assertStatus(200)
         ->assertJsonCount(3, 'data');
});

test('el catálogo de tipos de combustible devuelve la lista', function () {
    FuelType::factory()->count(4)->create();

    $this->getJson('/api/catalog/fuel-types')
         ->assertStatus(200)
         ->assertJsonCount(4, 'data');
});

test('el catálogo de tipos de coche devuelve la lista', function () {
    CarType::factory()->count(5)->create();

    $this->getJson('/api/catalog/car-types')
         ->assertStatus(200)
         ->assertJsonCount(5, 'data');
});

test('los endpoints del catálogo son públicos y no necesitan token', function () {
    $this->getJson('/api/catalog/makers')->assertStatus(200);
    $this->getJson('/api/catalog/fuel-types')->assertStatus(200);
    $this->getJson('/api/catalog/car-types')->assertStatus(200);
});
