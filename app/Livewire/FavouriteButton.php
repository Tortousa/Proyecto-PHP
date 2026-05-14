<?php

namespace App\Livewire;

use App\Models\Car;
use Livewire\Component;

// Componente Livewire — botón de favorito en tiempo real.
// Al hacer clic añade o quita el coche de favoritos sin recargar la página.
// Si el usuario no está autenticado lo redirige al login.
class FavouriteButton extends Component
{
    public int $carId;
    public bool $isFavourite = false;

    // mount() se ejecuta una vez al inicializar el componente
    // y recibe las props que pasamos desde el Blade padre (:car-id="$car->id")
    public function mount(int $carId): void
    {
        $this->carId = $carId;

        // Solo consultamos si hay sesión activa
        $this->isFavourite = auth()->check()
            ? auth()->user()->favouriteCars()->where('car_id', $carId)->exists()
            : false;
    }


    // Toggle: añade si no está en favoritos, quita si ya lo está
    public function toggle(): void
    {
        if (!auth()->check()) {
            $this->redirectRoute('login');
            return;
        }

        $user = auth()->user();

        if ($this->isFavourite) {
            $user->favouriteCars()->detach($this->carId);
        } else {
            $user->favouriteCars()->attach($this->carId, [
                'notes'    => null,
                'added_at' => now(),
            ]);
        }

        $this->isFavourite = !$this->isFavourite;

        $this->dispatch('favouriteToggled');
    }

    public function render()
    {
        return view('livewire.favourite-button');
    }
}
