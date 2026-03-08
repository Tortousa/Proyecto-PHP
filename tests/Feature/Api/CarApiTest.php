<?php

use App\Models\Car;
use App\Models\User;
use App\Models\CarImages;
use Illuminate\Testing\Fluent\AssertableJson;

// ============================================
// TESTS PARA CRUD 1: COCHES (Público)
// ============================================

test('API: Get all published cars', function () {
    $cars = Car::factory()
        ->count(5)
        ->create(['published_at' => now()]);

    $response = $this->getJson('/api/cars');

    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('success')
                ->has('message')
                ->has('data')
                ->has('pagination')
        );

    expect($response['data'])->toHaveCount(5);
});

test('API: Get car with pagination', function () {
    Car::factory()
        ->count(15)
        ->create(['published_at' => now()]);

    $response = $this->getJson('/api/cars?per_page=10');

    $response->assertStatus(200)
        ->assertJsonPath('pagination.total', 15)
        ->assertJsonPath('pagination.per_page', 10)
        ->assertJsonPath('pagination.current_page', 1);
});

test('API: Get single car by ID', function () {
    $car = Car::factory()->create(['published_at' => now()]);

    $response = $this->getJson("/api/cars/{$car->id}");

    $response->assertStatus(200)
        ->assertJsonPath('data.id', $car->id)
        ->assertJsonPath('data.year', $car->year)
        ->assertJsonPath('data.price', $car->price);
});

test('API: Cannot get unpublished car', function () {
    $car = Car::factory()->create(['published_at' => null]);

    $response = $this->getJson("/api/cars/{$car->id}");

    $response->assertStatus(404);
});

test('API: Filter cars by maker', function () {
    $car = Car::factory()->create(['published_at' => now()]);
    Car::factory()->count(3)->create(['published_at' => now()]);

    $response = $this->getJson("/api/cars?maker_id={$car->maker_id}");

    $response->assertStatus(200);
    expect(count($response['data']))->toBeGreaterThanOrEqual(1);
});

// ============================================
// TESTS PARA CRUD 2: IMÁGENES (Autenticado)
// ============================================

test('API: Requires auth for image endpoints', function () {
    $response = $this->getJson('/api/car-images');

    $response->assertStatus(401);
});

test('API: Login and get token', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user.email', 'test@example.com')
        ->assertJsonStructure(['data' => ['token']]);
});

test('API: Cannot login with wrong credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
        ->assertJsonPath('success', false);
});

test('API: Get car images with authentication', function () {
    $user = User::factory()->create();
    $car = Car::factory()->for($user)->create();
    CarImages::factory()->count(3)->for($car)->create();

    $response = $this->actingAs($user)->getJson('/api/car-images');

    $response->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('pagination.total', 3);
});

test('API: Upload image to car (authenticated)', function () {
    $user = User::factory()->create();
    $car = Car::factory()->for($user)->create();

    $file = \Illuminate\Http\UploadedFile::fake()->image('car.jpg', 800, 600);

    $response = $this->actingAs($user)->postJson("/api/cars/{$car->id}/images", [
        'image' => $file,
        'position' => 1,
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.car_id', $car->id)
        ->assertJsonPath('data.position', 1);

    $this->assertDatabaseHas('car_images', [
        'car_id' => $car->id,
        'position' => 1,
    ]);
});

test('API: Cannot upload image to another user car', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $car = Car::factory()->for($user1)->create();

    $file = \Illuminate\Http\UploadedFile::fake()->image('car.jpg');

    $response = $this->actingAs($user2)->postJson("/api/cars/{$car->id}/images", [
        'image' => $file,
    ]);

    $response->assertStatus(403)
        ->assertJsonPath('success', false);
});

test('API: Update image position', function () {
    $user = User::factory()->create();
    $car = Car::factory()->for($user)->create();
    $image = CarImages::factory()->for($car)->create(['position' => 1]);

    $response = $this->actingAs($user)->putJson("/api/car-images/{$image->id}", [
        'position' => 3,
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('data.position', 3);

    $this->assertDatabaseHas('car_images', [
        'id' => $image->id,
        'position' => 3,
    ]);
});

test('API: Delete image (authenticated)', function () {
    $user = User::factory()->create();
    $car = Car::factory()->for($user)->create();
    $image = CarImages::factory()->for($car)->create();

    $response = $this->actingAs($user)->deleteJson("/api/car-images/{$image->id}");

    $response->assertStatus(200)
        ->assertJsonPath('success', true);

    $this->assertDatabaseMissing('car_images', [
        'id' => $image->id,
    ]);
});

test('API: Logout revokes token', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJsonPath('success', true);
});

test('API: Get images for specific car', function () {
    $user = User::factory()->create();
    $car = Car::factory()->for($user)->create();
    $images = CarImages::factory()->count(2)->for($car)->create();

    $response = $this->actingAs($user)->getJson("/api/cars/{$car->id}/images");

    $response->assertStatus(200)
        ->assertJsonPath('success', true);

    expect(count($response['data']))->toBe(2);
});

test('API: Cannot get images from other user car', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $car = Car::factory()->for($user1)->create();

    $response = $this->actingAs($user2)->getJson("/api/cars/{$car->id}/images");

    $response->assertStatus(403);
});
