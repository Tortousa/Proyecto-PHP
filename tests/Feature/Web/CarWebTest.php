<?php

// Tests del CRUD web de coches.
// Comprueban que las rutas de gestión de anuncios funcionan correctamente
// y que los permisos están bien aplicados (solo el dueño puede editar/borrar).

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

    $maker    = Maker::factory()->create();
    $carModel = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType  = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    $this->ref  = compact('maker', 'carModel', 'carType', 'fuelType', 'city');
    $this->user = User::factory()->create();
});

// ── INDEX ──────────────────────────────────────────────────────────────────────

test('el usuario puede ver la lista de sus coches (MyCars)', function () {
    $this->actingAs($this->user)
         ->get(route('cars.index'))
         ->assertStatus(200);
});

test('sin autenticación, la lista de coches redirige al login', function () {
    $this->get(route('cars.index'))->assertRedirect('/login');
});

// ── CREATE ─────────────────────────────────────────────────────────────────────

test('el usuario puede ver el formulario de crear coche', function () {
    $this->actingAs($this->user)
         ->get(route('cars.create'))
         ->assertStatus(200);
});

// ── STORE ──────────────────────────────────────────────────────────────────────

test('el usuario puede crear un coche nuevo', function () {
    $vin = strtoupper(\Illuminate\Support\Str::random(17));

    $this->actingAs($this->user)
         ->post(route('cars.store'), [
             'maker_id'     => $this->ref['maker']->id,
             'model_id'     => $this->ref['carModel']->id,
             'city_id'      => $this->ref['city']->id,
             'car_type_id'  => $this->ref['carType']->id,
             'fuel_type_id' => $this->ref['fuelType']->id,
             'year'         => 2020,
             'price'        => 15000,
             'mileage'      => 45000,
             'vin'          => $vin,
             'phone'        => '612345678',
             'address'      => 'Calle Mayor 1',
         ])
         ->assertRedirect(route('cars.index'));

    $this->assertDatabaseHas('cars', ['vin' => $vin]);
});

// ── SHOW ───────────────────────────────────────────────────────────────────────

test('el usuario puede ver el detalle de su coche', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($this->user)
         ->get(route('cars.show', $car))
         ->assertStatus(200);
});

test('un visitante sin cuenta puede ver el detalle de un coche', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->get(route('cars.show', $car))->assertStatus(200);
});

// ── EDIT ───────────────────────────────────────────────────────────────────────

test('el dueño puede ver el formulario de edición', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($this->user)
         ->get(route('cars.edit', $car))
         ->assertStatus(200);
});

test('otro usuario no puede ver el formulario de edición (403)', function () {
    $car   = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);
    $other = User::factory()->create();

    $this->actingAs($other)
         ->get(route('cars.edit', $car))
         ->assertStatus(403);
});

// ── UPDATE ─────────────────────────────────────────────────────────────────────

test('el dueño puede actualizar su coche', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($this->user)
         ->put(route('cars.update', $car), [
             'maker_id'     => $this->ref['maker']->id,
             'model_id'     => $this->ref['carModel']->id,
             'city_id'      => $this->ref['city']->id,
             'car_type_id'  => $this->ref['carType']->id,
             'fuel_type_id' => $this->ref['fuelType']->id,
             'year'         => 2021,
             'price'        => 18000,
             'mileage'      => 50000,
             'vin'          => $car->vin,
             'phone'        => '612345678',
             'address'      => 'Calle Nueva 5',
         ])
         ->assertRedirect(route('cars.index'));

    $this->assertDatabaseHas('cars', ['id' => $car->id, 'price' => 18000]);
});

// ── DESTROY ────────────────────────────────────────────────────────────────────

test('el dueño puede eliminar su coche', function () {
    $car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($this->user)
         ->delete(route('cars.destroy', $car))
         ->assertRedirect(route('cars.index'));

    $this->assertSoftDeleted('cars', ['id' => $car->id]);
});

test('otro usuario no puede eliminar el coche ajeno (403)', function () {
    $car   = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);
    $other = User::factory()->create();

    $this->actingAs($other)
         ->delete(route('cars.destroy', $car))
         ->assertStatus(403);
});

// ── INDEX CON FILTROS ──────────────────────────────────────────────────────────

test('el índice filtra por marca', function () {
    $this->actingAs($this->user)
         ->get(route('cars.index', ['maker' => $this->ref['maker']->name]))
         ->assertStatus(200);
});

test('el índice filtra por rango de precio', function () {
    $this->actingAs($this->user)
         ->get(route('cars.index', ['min_price' => 5000, 'max_price' => 30000]))
         ->assertStatus(200);
});

test('el índice filtra por tipo de combustible', function () {
    $this->actingAs($this->user)
         ->get(route('cars.index', ['fuel_type' => $this->ref['fuelType']->id]))
         ->assertStatus(200);
});

// ── STORE / UPDATE CON IMÁGENES ────────────────────────────────────────────────

test('el usuario puede crear un coche con imagen adjunta', function () {
    $file = \Illuminate\Http\UploadedFile::fake()->image('car.jpg', 640, 480);

    $this->actingAs($this->user)
         ->post(route('cars.store'), [
             'maker_id'     => $this->ref['maker']->id,
             'model_id'     => $this->ref['carModel']->id,
             'city_id'      => $this->ref['city']->id,
             'car_type_id'  => $this->ref['carType']->id,
             'fuel_type_id' => $this->ref['fuelType']->id,
             'year'         => 2022,
             'price'        => 12000,
             'mileage'      => 30000,
             'vin'          => strtoupper(\Illuminate\Support\Str::random(17)),
             'phone'        => '600111222',
             'address'      => 'Avenida Test 42',
             'images'       => [$file],
         ])
         ->assertRedirect(route('cars.index'));
});

// ── ADMIN VE TODOS LOS COCHES ─────────────────────────────────────────────────

test('el admin ve todos los coches en el índice, no solo los suyos', function () {
    $admin = User::factory()->create(['rol' => 'admin']);
    $other = User::factory()->create();

    Car::factory()->create([
        'user_id'      => $other->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);

    $this->actingAs($admin)
         ->get(route('cars.index'))
         ->assertStatus(200);
});

// ── STORE / UPDATE CON IMÁGENES ────────────────────────────────────────────────

test('el dueño puede actualizar un coche añadiendo una imagen', function () {
    $car  = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->ref['city']->id,
    ]);
    $file = \Illuminate\Http\UploadedFile::fake()->image('update.jpg');

    $this->actingAs($this->user)
         ->put(route('cars.update', $car), [
             'maker_id'     => $this->ref['maker']->id,
             'model_id'     => $this->ref['carModel']->id,
             'city_id'      => $this->ref['city']->id,
             'car_type_id'  => $this->ref['carType']->id,
             'fuel_type_id' => $this->ref['fuelType']->id,
             'year'         => 2021,
             'price'        => 19000,
             'mileage'      => 55000,
             'vin'          => $car->vin,
             'phone'        => '612345678',
             'address'      => 'Calle Nueva 5',
             'images'       => [$file],
         ])
         ->assertRedirect(route('cars.index'));
});
