<?php

namespace App\Policies;

use App\Models\User;

// Controla quién puede gestionar cuentas de usuario.
// Regla general: el admin gestiona a todos; un usuario solo puede ver/editar/borrar la suya.
class UserPolicy
{
    // Solo el admin puede ver la lista completa de usuarios
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // El admin puede ver cualquier perfil; un usuario solo puede ver el suyo
    public function view(User $user, User $model): bool
    {
        return $user->hasRole('admin') || $user->id === $model->id;
    }

    // El admin puede editar cualquier cuenta; un usuario solo puede editar la suya
    public function update(User $user, User $model): bool
    {
        return $user->hasRole('admin') || $user->id === $model->id;
    }

    // El admin puede borrar cualquier cuenta; un usuario puede borrar la suya propia
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('admin') || $user->id === $model->id;
    }

    // Solo el admin puede crear cuentas desde el panel
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // Nadie puede restaurar usuarios eliminados
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    // Nadie puede borrar permanentemente usuarios
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
