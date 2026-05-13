<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;

class PublishPendingCars extends Command
{
    protected $signature = 'app:publish-pending-cars';
    protected $description = 'Publica todos los coches que aún no tienen fecha de publicación';

    public function handle(): void
    {
        $pending = Car::whereNull('published_at')->get();

        if ($pending->isEmpty()) {
            $this->info('No hay coches pendientes de publicación.');
            return;
        }

        foreach ($pending as $car) {
            $car->update(['published_at' => now()]);
        }

        $this->info("Publicados {$pending->count()} coches correctamente.");
    }
}
