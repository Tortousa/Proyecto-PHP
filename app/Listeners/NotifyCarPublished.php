<?php

namespace App\Listeners;

use App\Events\CarPublished;
use App\Jobs\SendCarPublishedEmailJob;

// Listener del evento CarPublished.
// Delega el envío del email al job para no bloquear la respuesta HTTP.
class NotifyCarPublished
{
    public function handle(CarPublished $event): void
    {
        SendCarPublishedEmailJob::dispatch($event->car);
    }
}
