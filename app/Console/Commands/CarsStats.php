<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\User;
use Illuminate\Console\Command;

class CarsStats extends Command
{
    protected $signature = 'app:cars-stats';
    protected $description = 'Muestra estadísticas generales de coches y usuarios';

    public function handle(): void
    {
        $total      = Car::count();
        $published  = Car::whereNotNull('published_at')->count();
        $drafts     = Car::whereNull('published_at')->count();
        $avgPrice   = Car::whereNotNull('published_at')->avg('price') ?? 0;
        $users      = User::count();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total coches',        $total],
                ['Publicados',          $published],
                ['Borradores',          $drafts],
                ['Precio medio (€)',    number_format($avgPrice, 2)],
                ['Usuarios registrados', $users],
            ]
        );
    }
}
