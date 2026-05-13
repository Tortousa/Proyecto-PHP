<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;

class CleanOldDrafts extends Command
{
    protected $signature = 'app:clean-old-drafts {days=30 : Días sin publicar para considerar borrador antiguo}';
    protected $description = 'Elimina coches no publicados más antiguos que N días';

    public function handle(): void
    {
        $days = (int) $this->argument('days');

        $deleted = Car::whereNull('published_at')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Eliminados {$deleted} borradores con más de {$days} días sin publicar.");
    }
}
