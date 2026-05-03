<?php

namespace App\Jobs;

use App\Mail\CarPublishedMail;
use App\Models\Car;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

// Este job notifica al dueño del coche de que su anuncio ya está publicado.
// Va a la cola para no bloquear la respuesta al usuario mientras se envía el email.
class SendCarPublishedEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private Car $car) {}

    public function handle(): void
    {
        // Cargamos el dueño del coche para tener su email disponible
        $owner = $this->car->owner;

        Mail::to($owner->email)->send(new CarPublishedMail($this->car));
    }
}
