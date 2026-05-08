<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Evento que se dispara cuando un coche queda publicado.
// Lo escucha NotifyCarPublished, que despacha el job de notificación al vendedor.
class CarPublished
{
    use Dispatchable, SerializesModels;

    public function __construct(public Car $car) {}
}
