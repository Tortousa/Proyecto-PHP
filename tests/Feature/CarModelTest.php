<?php

// Tests de los scopes y relaciones del modelo Car.
// Verifican que los scopes filtran correctamente y que las relaciones devuelven los datos esperados.

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

    $maker      = Maker::factory()->create();
    $carModel   = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType    = CarType::factory()->create();
    $fuelType   = FuelType::factory()->create();
    $this->state = State::factory()->create();
    $this->city  = City::factory()->create(['state_id' => $this->state->id]);
    $this->owner = User::factory()->create();

    $this->ref = compact('maker', 'carModel', 'carType', 'fuelType');

    $this->car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $maker->id,
        'model_id'     => $carModel->id,
        'car_type_id'  => $carType->id,
        'fuel_type_id' => $fuelType->id,
        'city_id'      => $this->city->id,
        'price'        => 15000,
        'published_at' => now(),
    ]);
});

// ── SCOPES ────────────────────────────────────────────────────────────────────

test('scopeInState filtra coches por provincia', function () {
    $otherState = State::factory()->create();
    $otherCity  = City::factory()->create(['state_id' => $otherState->id]);

    Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $otherCity->id,
    ]);

    $results = Car::inState($this->state->id)->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($this->car->id);
});

test('scopePriceBetween filtra coches por rango de precio', function () {
    Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->ref['maker']->id,
        'model_id'     => $this->ref['carModel']->id,
        'car_type_id'  => $this->ref['carType']->id,
        'fuel_type_id' => $this->ref['fuelType']->id,
        'city_id'      => $this->city->id,
        'price'        => 50000,
    ]);

    $results = Car::priceBetween(10000, 20000)->get();

    expect($results)->toHaveCount(1)
        ->and((int) $results->first()->price)->toBe(15000);
});

// ── RELACIONES ────────────────────────────────────────────────────────────────

test('la relación favouredUsers devuelve los usuarios que marcaron el coche como favorito', function () {
    $fan = User::factory()->create();
    $fan->favouriteCars()->attach($this->car->id, ['notes' => null, 'added_at' => now()]);

    expect($this->car->favouredUsers)->toHaveCount(1)
        ->and($this->car->favouredUsers->first()->id)->toBe($fan->id);
});

test('la relación features devuelve una colección vacía si el coche no tiene características', function () {
    expect($this->car->features)->toBeEmpty();
});

// ── CarImages accessor ────────────────────────────────────────────────────────

test('CarImages url accessor devuelve Storage URL para rutas locales', function () {
    \Illuminate\Support\Facades\Storage::fake('public');

    $image = $this->car->images()->create([
        'image_path' => 'cars/test.jpg',
        'position'   => 1,
    ]);

    expect($image->url)->toContain('cars/test.jpg');
});

test('CarImages url accessor devuelve la URL externa tal cual', function () {
    $image = $this->car->images()->create([
        'image_path' => 'https://example.com/car.jpg',
        'position'   => 1,
    ]);

    expect($image->url)->toBe('https://example.com/car.jpg');
});
