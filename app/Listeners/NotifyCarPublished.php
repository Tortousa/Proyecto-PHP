<?php

namespace App\Listeners;

use App\Events\CarPublished;
use App\Jobs\SendCarPublishedEmailJob;

// Este listener escucha el evento CarPublished.
// Cuando se publica un coche, notifica al dueño por email.
class NotifyCarPublished
{
    public function handle(CarPublished $event): void
    {
        // Este job va a la cola (queue) porque enviar emails puede tardar.
        // Así el usuario recibe la respuesta inmediatamente y el email se manda en segundo plano.
        SendCarPublishedEmailJob::dispatch($event->car);
    }
}
