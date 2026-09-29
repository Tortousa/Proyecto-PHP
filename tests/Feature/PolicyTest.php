<?php

// Tests unitarios de las políticas (CarPolicy y UserPolicy).

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

test('CarPolicy viewAny y view — cualquier usuario autenticado puede listar y ver', function () {
    $policy = new CarPolicy();

    expect($policy->viewAny($this->user))->toBeTrue()
        ->and($policy->create($this->user))->toBeTrue()
        ->and($policy->view($this->user, $this->car))->toBeTrue();
});

test('CarPolicy update/delete — el dueño y el admin sí; un tercero no', function () {
    $policy = new CarPolicy();

    expect($policy->update($this->user, $this->car))->toBeTrue()   // dueño
        ->and($policy->update($this->admin, $this->car))->toBeTrue()  // admin
        ->and($policy->update($this->other, $this->car))->toBeFalse() // tercero
        ->and($policy->delete($this->user, $this->car))->toBeTrue()
        ->and($policy->delete($this->admin, $this->car))->toBeTrue()
        ->and($policy->delete($this->other, $this->car))->toBeFalse();
});

// ── UserPolicy ────────────────────────────────────────────────────────────────

test('UserPolicy viewAny — solo el admin puede listar usuarios', function () {
    $policy = new UserPolicy();

    expect($policy->viewAny($this->admin))->toBeTrue()
        ->and($policy->viewAny($this->user))->toBeFalse();
});

test('UserPolicy view/update/delete — el admin a todos; el usuario solo a sí mismo', function () {
    $policy = new UserPolicy();

    expect($policy->view($this->admin, $this->user))->toBeTrue()
        ->and($policy->view($this->user, $this->user))->toBeTrue()
        ->and($policy->view($this->user, $this->other))->toBeFalse()
        ->and($policy->update($this->user, $this->other))->toBeFalse()
        ->and($policy->delete($this->user, $this->other))->toBeFalse();
});

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
