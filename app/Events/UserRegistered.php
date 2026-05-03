<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Este evento se dispara justo después de que un usuario se registra.
// Su único trabajo es transportar el usuario recién creado hasta el listener.
class UserRegistered
{
    use Dispatchable, SerializesModels;

    // Guardamos el usuario para que el listener pueda usarlo
    public function __construct(public User $user) {}
}
