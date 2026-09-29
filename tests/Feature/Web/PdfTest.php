<?php

// Tests de la generación de PDFs (PdfController + PdfService).
// La ficha de un coche es pública; el informe general requiere usuario autenticado.

use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Event::fake();
    Storage::fake('public');

    $maker    = Maker::factory()->create();
    $carModel = CarModel::factory()->create(['maker_id' => $maker->id]);
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    $this->car = Car::factory()->create([
        'user_id'      => User::factory()->create()->id,
        'maker_id'     => $maker->id,
        'model_id'     => $carModel->id,
        'car_type_id'  => CarType::factory()->create()->id,
        'fuel_type_id' => FuelType::factory()->create()->id,
        'city_id'      => $city->id,
        'published_at' => now(),
    ]);
});

test('cualquier visitante puede descargar el PDF de la ficha de un coche', function () {
    $response = $this->get(route('cars.pdf', $this->car));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

test('un administrador puede descargar el informe PDF de anuncios', function () {
    $response = $this->actingAs(User::factory()->create(['rol' => 'admin']))
        ->get(route('admin.cars.report.pdf'));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

test('un usuario normal no puede descargar el informe PDF de anuncios', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.cars.report.pdf'))
        ->assertForbidden();
});

test('el informe PDF de anuncios requiere autenticación', function () {
    $this->get(route('admin.cars.report.pdf'))->assertRedirect(route('login'));
});

test('el PDF de la ficha embebe la imagen local del coche en base64', function () {
    // Reemplazamos la imagen placeholder (URL externa) por una local en el disco fake
    $this->car->images()->delete();
    Storage::disk('public')->put('cars/foto.jpg', 'contenido-binario-falso');
    $this->car->images()->create(['image_path' => 'cars/foto.jpg', 'position' => 1]);

    $response = $this->get(route('cars.pdf', $this->car));

    $response->assertOk();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

test('PdfService::stream devuelve un PDF en línea', function () {
    $response = app(\App\Services\PdfService::class)
        ->stream('pdfs.car-detail', ['car' => $this->car, 'imagenBase64' => null, 'logoBase64' => null], 'ficha.pdf');

    expect($response->headers->get('content-type'))->toContain('application/pdf');
});
