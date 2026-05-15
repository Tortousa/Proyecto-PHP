<?php

namespace App\Listeners;

use App\Events\CarPublished;
use App\Jobs\SendCarPublishedEmailJob;

// Listener del evento CarPublished.
// Delega el envío del email al job para no bloquear la respuesta HTTP.
// El informe de estadísticas al admin se envía por cron diario (console.php), no aquí.
class NotifyCarPublished
{
    public function handle(CarPublished $event): void
    {
        SendCarPublishedEmailJob::dispatch($event->car);
    }
}
