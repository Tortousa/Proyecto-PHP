<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Evento que se dispara cuando un usuario completa el registro.
// Lo escucha SendWelcomeMail, que a su vez despacha el job de email.
class UserRegistered
{
    use Dispatchable, SerializesModels;

    public function __construct(public User $user) {}
}
