<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmailJob;

// Este listener está "escuchando" el evento UserRegistered.
// Cuando alguien se registra, Laravel llama automáticamente al método handle().
class SendWelcomeMail
{
    public function handle(UserRegistered $event): void
    {
        // Despachamos el job que enviará el email de bienvenida.
        // Lo hacemos así (en vez de enviar el email aquí directamente)
        // para mantener separadas las responsabilidades.
        SendWelcomeEmailJob::dispatch($event->user);
    }
}
