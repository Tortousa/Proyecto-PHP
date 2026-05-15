<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Informe diario de estadísticas al administrador
Schedule::command('app:cars-stats')->dailyAt('08:00');

// Limpiar borradores abandonados cada semana
Schedule::command('app:clean-old-drafts')->weekly();
