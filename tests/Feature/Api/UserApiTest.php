<?php

// Tests de los endpoints de perfil de usuario autenticado.
// Comprueban que /user/me devuelve los datos correctos con estadísticas
// y que /user/favourites devuelve la lista paginada de coches favoritos.

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    Event::fake();

    // Datos de referencia para poder crear coches en los tests que los necesitan
    $maker    = Maker::factory()->create();
    $carModel = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType  = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    $this->ref  = compact('maker', 'carModel', 'carType', 'fuelType', 'city');
    $this->user = User::factory()->create();
});

// ── ME ─────────────────────────────────────────────────────────────────────────

test('un usuario autenticado puede ver su perfil en /user/me', function () {
    $response = $this->actingAs($this->user)
                     ->getJson('/api/user/me');

    $response->assertStatus(200)
             ->assertJsonFragment(['email' => $this->user->email]);
});

test('/user/me incluye las estadísticas de coches y favoritos', function () {
    $response = $this->actingAs($this->user)
                     ->getJson('/api/user/me');

    // El UserResource agrupa las estadísticas bajo la clave 'estadisticas'
    $response->assertStatus(200)
             ->assertJsonStructure(['estadisticas' => ['total_coches', 'total_favoritos']]);
});

test('no se puede acceder a /user/me sin autenticación', function () {
    $this->getJson('/api/user/me')->assertStatus(401);
});

// ── FAVOURITES ─────────────────────────────────────────────────────────────────

test('un usuario autenticado puede ver sus favoritos', function () {
    // Creamos un coche y lo añadimos a favoritos del usuario
    $car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
        'published_at' => now(),
    ]);

    $this->user->favouriteCars()->attach($car->id, ['added_at' => now()]);

    $response = $this->actingAs($this->user)
                     ->getJson('/api/user/favourites');

    $response->assertStatus(200)
             ->assertJsonCount(1, 'data');
});

test('la lista de favoritos está vacía si no se ha añadido ninguno', function () {
    $this->actingAs($this->user)
         ->getJson('/api/user/favourites')
         ->assertStatus(200)
         ->assertJsonCount(0, 'data');
});

test('no se puede acceder a /user/favourites sin autenticación', function () {
    $this->getJson('/api/user/favourites')->assertStatus(401);
});
