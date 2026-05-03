<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Este evento se dispara cuando un usuario publica un anuncio de coche.
// Lleva el coche publicado para que el listener sepa qué anuncio es y a quién notificar.
class CarPublished
{
    use Dispatchable, SerializesModels;

    // Guardamos el coche para que el listener pueda acceder a él y a su dueño
    public function __construct(public Car $car) {}
}
