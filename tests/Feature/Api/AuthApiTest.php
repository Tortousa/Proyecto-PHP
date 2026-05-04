<?php

// Tests de la API de autenticación.
// Comprueban que register, login, logout y me funcionan correctamente
// y que los errores de validación y credenciales devuelven los códigos correctos.

use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    // Interceptamos los emails para que no se intenten enviar de verdad durante los tests
    Mail::fake();
});

// ── REGISTER ──────────────────────────────────────────────────────────────────

test('un usuario puede registrarse correctamente', function () {
    $response = $this->postJson('/api/auth/register', [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'phone'                 => '612345678',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    // Debe devolver 201 con los campos user y token
    $response->assertStatus(201)
             ->assertJsonStructure(['message', 'user', 'token']);

    // El usuario debe haberse creado en la base de datos
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
});

test('el registro falla si falta el email', function () {
    $response = $this->postJson('/api/auth/register', [
        'name'                  => 'Test User',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['email']);
});

test('el registro falla si el email ya existe', function () {
    // Creamos un usuario con ese email primero
    User::factory()->create(['email' => 'repetido@example.com']);

    $response = $this->postJson('/api/auth/register', [
        'name'                  => 'Otro User',
        'email'                 => 'repetido@example.com',
        'phone'                 => '600000000',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['email']);
});

// ── LOGIN ──────────────────────────────────────────────────────────────────────

test('un usuario puede hacer login con credenciales correctas', function () {
    $user = User::factory()->create(['password' => bcrypt('Password123!')]);

    $response = $this->postJson('/api/auth/login', [
        'email'    => $user->email,
        'password' => 'Password123!',
    ]);

    // Debe devolver 200 con user y token
    $response->assertStatus(200)
             ->assertJsonStructure(['user', 'token']);
});

test('el login falla con credenciales incorrectas', function () {
    $user = User::factory()->create(['password' => bcrypt('correcta')]);

    $response = $this->postJson('/api/auth/login', [
        'email'    => $user->email,
        'password' => 'incorrecta',
    ]);

    $response->assertStatus(401)
             ->assertJson(['message' => 'Credenciales incorrectas.']);
});

// ── LOGOUT ─────────────────────────────────────────────────────────────────────

test('un usuario autenticado puede hacer logout', function () {
    $user = User::factory()->create();

    // actingAs() da un TransientToken sin delete() — necesitamos un token real en BD
    $token = $user->createToken('api-token')->plainTextToken;

    $this->withToken($token)
         ->postJson('/api/auth/logout')
         ->assertStatus(200)
         ->assertJson(['message' => 'Sesión cerrada correctamente.']);
});

test('no se puede hacer logout sin autenticación', function () {
    $this->postJson('/api/auth/logout')->assertStatus(401);
});

// ── ME ─────────────────────────────────────────────────────────────────────────

test('un usuario autenticado puede ver sus datos con /me', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->getJson('/api/auth/me')
         ->assertStatus(200)
         ->assertJsonFragment(['email' => $user->email]);
});

test('no se puede acceder a /me sin autenticación', function () {
    $this->getJson('/api/auth/me')->assertStatus(401);
});
