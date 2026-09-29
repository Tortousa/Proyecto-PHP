<?php

// Tests de las relaciones de los modelos de catálogo (Maker, CarModel, CarType,
// FuelType, City, State, CarFeatures). Verifican que cada relación apunta a la
// clave foránea correcta del esquema real.

use App\Models\Car;
use App\Models\CarFeatures;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    Event::fake();

    $this->maker    = Maker::factory()->create();
    $this->carModel = CarModel::factory()->create(['maker_id' => $this->maker->id]);
    $this->carType  = CarType::factory()->create();
    $this->fuelType = FuelType::factory()->create();
    $this->state    = State::factory()->create();
    $this->city     = City::factory()->create(['state_id' => $this->state->id]);
    $this->owner    = User::factory()->create();

    $this->car = Car::factory()->create([
        'user_id'      => $this->owner->id,
        'maker_id'     => $this->maker->id,
        'model_id'     => $this->carModel->id,
        'car_type_id'  => $this->carType->id,
        'fuel_type_id' => $this->fuelType->id,
        'city_id'      => $this->city->id,
        'published_at' => now(),
    ]);
});

// ── Maker ───────────────────────────────────────────────────────────────────

test('Maker tiene muchos coches', function () {
    expect($this->maker->cars)->toHaveCount(1)
        ->and($this->maker->cars->first()->id)->toBe($this->car->id);
});

test('Maker tiene muchos modelos', function () {
    expect($this->maker->models)->toHaveCount(1)
        ->and($this->maker->models->first()->id)->toBe($this->carModel->id);
});

// ── CarModel ──────────────────────────────────────────────────────────────────

test('CarModel pertenece a un maker', function () {
    expect($this->carModel->maker->id)->toBe($this->maker->id);
});

test('CarModel tiene coches a través de la FK model_id', function () {
    expect($this->carModel->cars)->toHaveCount(1)
        ->and($this->carModel->cars->first()->id)->toBe($this->car->id);
});

// ── CarType ───────────────────────────────────────────────────────────────────

test('CarType tiene muchos coches', function () {
    expect($this->carType->cars)->toHaveCount(1)
        ->and($this->carType->cars->first()->id)->toBe($this->car->id);
});

// ── FuelType ──────────────────────────────────────────────────────────────────

test('FuelType tiene muchos coches', function () {
    expect($this->fuelType->cars)->toHaveCount(1)
        ->and($this->fuelType->cars->first()->id)->toBe($this->car->id);
});

// ── City ──────────────────────────────────────────────────────────────────────

test('City tiene muchos coches', function () {
    expect($this->city->cars)->toHaveCount(1)
        ->and($this->city->cars->first()->id)->toBe($this->car->id);
});

test('City pertenece a una provincia', function () {
    expect($this->city->state->id)->toBe($this->state->id);
});

// ── State ─────────────────────────────────────────────────────────────────────

test('State tiene muchas ciudades', function () {
    expect($this->state->cities)->toHaveCount(1)
        ->and($this->state->cities->first()->id)->toBe($this->city->id);
});

test('State tiene coches a través de la ciudad (hasManyThrough)', function () {
    expect($this->state->cars)->toHaveCount(1)
        ->and($this->state->cars->first()->id)->toBe($this->car->id);
});

// ── CarFeatures ───────────────────────────────────────────────────────────────

test('CarFeatures pertenece a un coche', function () {
    CarFeatures::create(['car_id' => $this->car->id, 'abs' => true]);

    $features = CarFeatures::where('car_id', $this->car->id)->firstOrFail();

    expect($features->car->id)->toBe($this->car->id);
});
