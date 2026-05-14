<?php

// Tests del CRUD de usuarios (panel de administración).
// Solo accesible para administradores — verifica que el middleware
// de rol funciona y que el CRUD de admin cubre todos los casos.

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['rol' => 'admin']);
    $this->user  = User::factory()->create(['rol' => 'user']);
});

// ── ACCESO RESTRINGIDO ─────────────────────────────────────────────────────────

test('un usuario normal no puede acceder al panel de admin', function () {
    $this->actingAs($this->user)
         ->get(route('admin.users.index'))
         ->assertStatus(403);
});

test('sin autenticación, el panel de admin redirige al login', function () {
    $this->get(route('admin.users.index'))->assertRedirect('/login');
});

// ── INDEX ──────────────────────────────────────────────────────────────────────

test('el admin puede ver la lista de usuarios', function () {
    $this->actingAs($this->admin)
         ->get(route('admin.users.index'))
         ->assertStatus(200);
});

// ── SHOW ───────────────────────────────────────────────────────────────────────

test('el admin puede ver el perfil de cualquier usuario', function () {
    $this->actingAs($this->admin)
         ->get(route('admin.users.show', $this->user))
         ->assertStatus(200);
});

// ── EDIT ───────────────────────────────────────────────────────────────────────

test('el admin puede ver el formulario de edición de usuario', function () {
    $this->actingAs($this->admin)
         ->get(route('admin.users.edit', $this->user))
         ->assertStatus(200);
});

// ── UPDATE ─────────────────────────────────────────────────────────────────────

test('el admin puede actualizar el nombre de un usuario', function () {
    $this->actingAs($this->admin)
         ->put(route('admin.users.update', $this->user), [
             'name'  => 'Nombre Modificado',
             'email' => $this->user->email,
             'rol'   => 'user',
         ])
         ->assertRedirect(route('admin.users.show', $this->user));

    $this->assertDatabaseHas('users', ['id' => $this->user->id, 'name' => 'Nombre Modificado']);
});

test('el admin puede cambiar el rol de un usuario a admin', function () {
    $this->actingAs($this->admin)
         ->put(route('admin.users.update', $this->user), [
             'name'  => $this->user->name,
             'email' => $this->user->email,
             'rol'   => 'admin',
         ])
         ->assertRedirect();

    $this->assertDatabaseHas('users', ['id' => $this->user->id, 'rol' => 'admin']);
});

// ── DESTROY ────────────────────────────────────────────────────────────────────

test('el admin puede actualizar la contraseña de un usuario', function () {
    $this->actingAs($this->admin)
         ->put(route('admin.users.update', $this->user), [
             'name'                  => $this->user->name,
             'email'                 => $this->user->email,
             'rol'                   => 'user',
             'password'              => 'NuevaPassword123!',
             'password_confirmation' => 'NuevaPassword123!',
         ])
         ->assertRedirect(route('admin.users.show', $this->user));
});

// ── DESTROY ────────────────────────────────────────────────────────────────────

test('el admin puede eliminar un usuario', function () {
    $userToDelete = User::factory()->create(['rol' => 'user']);

    $this->actingAs($this->admin)
         ->delete(route('admin.users.destroy', $userToDelete))
         ->assertRedirect(route('admin.users.index'));

    $this->assertNull($userToDelete->fresh());
});
