<?php

namespace App\Console\Commands;

use App\Mail\StatsReportMail;
use App\Models\Car;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CarsStats extends Command
{
    protected $signature = 'app:cars-stats';
    protected $description = 'Muestra estadísticas generales de coches y usuarios, y envía un informe por email al administrador';

    public function handle(): void
    {
        $total     = Car::count();
        $published = Car::whereNotNull('published_at')->count();
        $drafts    = Car::whereNull('published_at')->count();
        $avgPrice  = Car::whereNotNull('published_at')->avg('price') ?? 0;
        $users     = User::count();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total coches',         $total],
                ['Publicados',           $published],
                ['Borradores',           $drafts],
                ['Precio medio (€)',     number_format($avgPrice, 2)],
                ['Usuarios registrados', $users],
            ]
        );

        $admin = User::where('rol', 'admin')->first();

        if ($admin) {
            Mail::to($admin->email)->send(
                new StatsReportMail($total, $published, $drafts, (float) $avgPrice, $users)
            );
            $this->info("Informe enviado a {$admin->email}.");
        } else {
            $this->warn('No se encontró ningún administrador para enviar el informe.');
        }
    }
}
