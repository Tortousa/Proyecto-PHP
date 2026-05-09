<?php

// Tests unitarios de las políticas (CarPolicy y UserPolicy).
// Verifican los métodos que no se cubren indirectamente por los tests de controlador:
// restore, forceDelete y los métodos de UserPolicy.

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use App\Policies\CarPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    Event::fake();
    $this->admin = User::factory()->create(['rol' => 'admin']);
    $this->user  = User::factory()->create(['rol' => 'user']);
    $this->other = User::factory()->create(['rol' => 'user']);

    // Datos mínimos para crear coches
    $maker    = Maker::factory()->create();
    $carModel = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType  = CarType::factory()->create();
    $fuelType = FuelType::factory()->create();
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    $this->car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $maker->id,
        'model_id'     => $carModel->id,
        'car_type_id'  => $carType->id,
        'fuel_type_id' => $fuelType->id,
        'city_id'      => $city->id,
    ]);
});

// ── CarPolicy ─────────────────────────────────────────────────────────────────

test('CarPolicy restore — solo el admin o el dueño pueden restaurar', function () {
    $policy = new CarPolicy();

    expect($policy->restore($this->admin, $this->car))->toBeTrue();
    expect($policy->restore($this->user, $this->car))->toBeTrue();
    expect($policy->restore($this->other, $this->car))->toBeFalse();
});

test('CarPolicy forceDelete — solo el admin puede borrar permanentemente', function () {
    $policy = new CarPolicy();

    expect($policy->forceDelete($this->admin, $this->car))->toBeTrue();
    expect($policy->forceDelete($this->user, $this->car))->toBeFalse();
});

// ── UserPolicy ────────────────────────────────────────────────────────────────

test('UserPolicy create — solo el admin puede crear usuarios', function () {
    $policy = new UserPolicy();

    expect($policy->create($this->admin))->toBeTrue();
    expect($policy->create($this->user))->toBeFalse();
});

test('UserPolicy restore — nadie puede restaurar usuarios', function () {
    $policy = new UserPolicy();

    expect($policy->restore($this->admin, $this->user))->toBeFalse();
    expect($policy->restore($this->user, $this->other))->toBeFalse();
});

test('UserPolicy forceDelete — nadie puede borrar permanentemente usuarios', function () {
    $policy = new UserPolicy();

    expect($policy->forceDelete($this->admin, $this->user))->toBeFalse();
});
