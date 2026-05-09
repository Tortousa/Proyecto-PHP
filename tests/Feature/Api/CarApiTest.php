<?php

// Tests de la API de coches (CRUD completo).
// Comprueban el listado público con filtros, el detalle, y las operaciones
// protegidas: crear, editar y eliminar. También verifican que los permisos
// funcionan bien — solo el dueño puede tocar su anuncio.

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Event;

// Antes de cada test creamos los datos de referencia que necesita el factory de coches.
// Sin esto, Maker::inRandomOrder()->first() devuelve null y el factory revienta.
beforeEach(function () {
    // Interceptamos los eventos para que los jobs de email no se disparen durante los tests
    Event::fake();

    $maker    = Maker::factory()->create();
    $carModel = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType  = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    // Guardamos las referencias para reutilizarlas en los tests
    $this->ref   = compact('maker', 'carModel', 'carType', 'fuelType', 'city');
    $this->owner = User::factory()->create();
});

// Devuelve el array de campos mínimos para crear o editar un coche.
// Lo usamos tanto en store como en update para no repetir el mismo bloque.
function carPayload(array $ref, array $overrides = []): array
{
    return array_merge([
        'maker_id'     => $ref['maker']->id,
        'model_id'     => $ref['carModel']->id,
        'city_id'      => $ref['city']->id,
        'car_type_id'  => $ref['carType']->id,
        'fuel_type_id' => $ref['fuelType']->id,
        'year'         => 2020,
        'price'        => 15000,
        'mileage'      => 45000,
        'vin'          => strtoupper(\Illuminate\Support\Str::random(17)),
        'phone'        => '612345678',
        'address'      => 'Calle Mayor 1',
    ], $overrides);
}

// ── INDEX ──────────────────────────────────────────────────────────────────────

test('el listado público devuelve los coches publicados', function () {
    Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
        'published_at' => now(),
    ]);

    $this->getJson('/api/cars')
         ->assertStatus(200)
         ->assertJsonStructure(['data']);
});

test('el listado no incluye coches sin publicar', function () {
    // Coche sin published_at — no debe aparecer en el listado público
    Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
        'published_at' => null,
    ]);

    $response = $this->getJson('/api/cars')->assertStatus(200);
    // El data puede venir como array vacío en el wrapper o sin él — comprobamos que no hay coches
    expect($response->json('data') ?? $response->json())->toBeEmpty();
});

// ── SHOW ───────────────────────────────────────────────────────────────────────

test('se puede ver el detalle de un coche existente', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->getJson("/api/cars/{$car->id}")
         ->assertStatus(200)
         ->assertJsonFragment(['id' => $car->id]);
});

test('pedir el detalle de un coche que no existe devuelve 404', function () {
    $this->getJson('/api/cars/99999')->assertStatus(404);
});

// ── STORE ──────────────────────────────────────────────────────────────────────

test('un usuario autenticado puede publicar un coche nuevo', function () {
    $vin = strtoupper(\Illuminate\Support\Str::random(17));

    $response = $this->actingAs($this->owner)
                     ->postJson('/api/cars', carPayload($this->ref, ['vin' => $vin]));

    $response->assertStatus(201);
    $this->assertDatabaseHas('cars', ['vin' => $vin]);
});

test('no se puede publicar un coche sin autenticación', function () {
    $this->postJson('/api/cars', [])->assertStatus(401);
});

test('el store falla si faltan campos obligatorios', function () {
    $this->actingAs($this->owner)
         ->postJson('/api/cars', ['price' => 15000])
         ->assertStatus(422)
         ->assertJsonValidationErrors(['maker_id', 'model_id', 'vin']);
});

// ── UPDATE ─────────────────────────────────────────────────────────────────────

test('el dueño puede editar su propio coche', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($this->owner)
         ->putJson("/api/cars/{$car->id}", carPayload($this->ref, ['price' => 20000]))
         ->assertStatus(200)
         ->assertJsonFragment(['price' => 20000]);
});

test('un usuario no puede editar el coche de otro usuario', function () {
    $car   = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);
    $other = User::factory()->create();

    $this->actingAs($other)
         ->putJson("/api/cars/{$car->id}", carPayload($this->ref, ['price' => 1]))
         ->assertStatus(403);
});

test('no se puede editar un coche sin autenticación', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->putJson("/api/cars/{$car->id}", ['price' => 1])->assertStatus(401);
});

// ── DESTROY ────────────────────────────────────────────────────────────────────

test('el dueño puede eliminar su propio coche', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($this->owner)
         ->deleteJson("/api/cars/{$car->id}")
         ->assertStatus(200)
         ->assertJson(['message' => 'Coche eliminado correctamente.']);

    // El modelo usa SoftDeletes — comprobamos que no se ha borrado físicamente
    $this->assertSoftDeleted('cars', ['id' => $car->id]);
});

test('un usuario no puede eliminar el coche de otro usuario', function () {
    $car   = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);
    $other = User::factory()->create();

    $this->actingAs($other)
         ->deleteJson("/api/cars/{$car->id}")
         ->assertStatus(403);
});

test('no se puede eliminar un coche sin autenticación', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->deleteJson("/api/cars/{$car->id}")->assertStatus(401);
});

// ── INDEX CON FILTROS ──────────────────────────────────────────────────────────

test('el índice API filtra por nombre de marca', function () {
    Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
        'published_at' => now(),
    ]);

    $this->getJson('/api/cars?maker=' . $this->ref['maker']->name)
         ->assertStatus(200);
});

test('el índice API filtra por rango de precio', function () {
    Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
        'published_at' => now(),
        'price'        => 20000,
    ]);

    $this->getJson('/api/cars?min_price=10000&max_price=30000')
         ->assertStatus(200);
});

test('el índice API filtra por tipo de combustible', function () {
    $this->getJson('/api/cars?fuel_type=' . $this->ref['fuelType']->id)
         ->assertStatus(200);
});
