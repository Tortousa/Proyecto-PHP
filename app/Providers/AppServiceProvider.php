<?php

namespace App\Providers;

use App\Events\CarPublished;
use App\Events\UserRegistered;
use App\Listeners\NotifyCarPublished;
use App\Listeners\SendWelcomeMail;
use App\Models\Car;
use App\Models\FuelType;
use App\Models\User;
use App\Policies\CarPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registramos qué listener escucha cada evento
        Event::listen(UserRegistered::class, SendWelcomeMail::class);
        Event::listen(CarPublished::class, NotifyCarPublished::class);

        Gate::policy(Car::class, CarPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        // Esto inyecta $fuelTypes automáticamente SOLO en el componente de filtros
        View::composer('components.car-filters', function ($view) {
            $view->with('fuelTypes', FuelType::all());
        });
    }
}
