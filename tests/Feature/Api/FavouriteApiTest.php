<?php

// Tests del endpoint de favoritos.
// Comprueban el toggle (añadir/quitar), que se guardan los datos del pivote
// (notes y added_at) y que sin autenticación devuelve 401.

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Event;

// Creamos los datos de referencia y un coche de prueba antes de cada test
beforeEach(function () {
    Event::fake();

    $maker    = Maker::factory()->create();
    $carModel = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType  = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    $this->user = User::factory()->create();
    $this->car  = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $maker->id,
        'model_id'     => $carModel->id,
        'car_type_id'  => $carType->id,
        'fuel_type_id' => $fuelType->id,
        'city_id'      => $city->id,
        'published_at' => now(),
    ]);
});

// ── TOGGLE ─────────────────────────────────────────────────────────────────────

test('un usuario autenticado puede añadir un coche a favoritos', function () {
    $response = $this->actingAs($this->user)
                     ->postJson("/api/cars/{$this->car->id}/favourite");

    $response->assertStatus(200)
             ->assertJsonPath('data.favourite', true);

    // Comprobamos que el registro existe en la tabla pivote
    $this->assertDatabaseHas('favourite_cars', [
        'user_id' => $this->user->id,
        'car_id'  => $this->car->id,
    ]);
});

test('volver a llamar al toggle quita el coche de favoritos', function () {
    // Primer llamada — añadir
    $this->actingAs($this->user)
         ->postJson("/api/cars/{$this->car->id}/favourite");

    // Segunda llamada — quitar
    $response = $this->actingAs($this->user)
                     ->postJson("/api/cars/{$this->car->id}/favourite");

    $response->assertStatus(200)
             ->assertJsonPath('data.favourite', false);

    $this->assertDatabaseMissing('favourite_cars', [
        'user_id' => $this->user->id,
        'car_id'  => $this->car->id,
    ]);
});

test('el toggle guarda la nota personal en la tabla pivote', function () {
    $nota = 'Me gusta el color y el precio';

    $response = $this->actingAs($this->user)
                     ->postJson("/api/cars/{$this->car->id}/favourite", [
                         'notes' => $nota,
                     ]);

    $response->assertStatus(200)
             ->assertJsonPath('data.favourite', true)
             ->assertJsonPath('data.notes', $nota);

    // La nota debe haberse guardado en la columna especial del pivote
    $this->assertDatabaseHas('favourite_cars', [
        'user_id' => $this->user->id,
        'car_id'  => $this->car->id,
        'notes'   => $nota,
    ]);
});

test('el toggle guarda la fecha added_at en la tabla pivote', function () {
    $this->actingAs($this->user)
         ->postJson("/api/cars/{$this->car->id}/favourite");

    // Debe existir un registro con added_at no nulo
    $pivot = \Illuminate\Support\Facades\DB::table('favourite_cars')
        ->where('user_id', $this->user->id)
        ->where('car_id', $this->car->id)
        ->first();

    expect($pivot->added_at)->not->toBeNull();
});

test('no se puede usar el toggle de favoritos sin autenticación', function () {
    $this->postJson("/api/cars/{$this->car->id}/favourite")
         ->assertStatus(401);
});

test('el toggle devuelve 404 si el coche no existe', function () {
    $this->actingAs($this->user)
         ->postJson('/api/cars/99999/favourite')
         ->assertStatus(404);
});
