<?php

// Tests del perfil web.
// Comprueban la página "My Profile" (me), la actualización de datos
// y la eliminación de cuenta desde la vista de perfil.

use App\Models\User;

test('el usuario puede ver su página de perfil (me)', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get(route('profile.me'))
         ->assertStatus(200);
});

test('sin autenticación, el perfil redirige al login', function () {
    $this->get(route('profile.me'))->assertRedirect('/login');
});

test('el usuario puede ver el formulario de edición de perfil', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get(route('profile.edit'))
         ->assertStatus(200);
});

test('el usuario puede actualizar su nombre', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->patch(route('profile.update'), [
             'name'  => 'Nombre Nuevo',
             'email' => $user->email,
         ])
         ->assertRedirect(route('profile.edit'));

    $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nombre Nuevo']);
});

test('el usuario puede eliminar su propia cuenta', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->delete(route('profile.destroy'), ['password' => 'password'])
         ->assertRedirect('/');

    $this->assertNull($user->fresh());
});

test('no se puede eliminar la cuenta con contraseña incorrecta', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->delete(route('profile.destroy'), ['password' => 'wrongpassword'])
         ->assertSessionHasErrorsIn('userDeletion', ['password']);
});
