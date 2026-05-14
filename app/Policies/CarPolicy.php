<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

// Controla quién puede hacer qué con los anuncios de coches.
// Regla general: el dueño gestiona sus propios anuncios; el admin lo puede todo.
class CarPolicy
{
    // Cualquier usuario autenticado puede ver el listado de coches
    public function viewAny(User $_user): bool
    {
        return true;
    }

    // Cualquier usuario autenticado puede publicar un anuncio nuevo
    public function create(User $_user): bool
    {
        return true;
    }

    // Cualquier usuario autenticado puede ver el detalle de un coche
    public function view(User $_user, Car $_car): bool
    {
        return true;
    }

    // Solo el dueño o el admin pueden editar un anuncio
    public function update(User $user, Car $car): bool
    {
        return $user->hasRole('admin') || $car->user_id === $user->id;
    }

    // Solo el dueño o el admin pueden eliminar un anuncio
    public function delete(User $user, Car $car): bool
    {
        return $user->hasRole('admin') || $car->user_id === $user->id;
    }
}
