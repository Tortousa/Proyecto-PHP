<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\FuelType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

// Componente Livewire — buscador en tiempo real del home.
// Cada vez que el usuario escribe o cambia un filtro, Livewire actualiza
// solo la sección de resultados sin recargar toda la página.
class CarSearch extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $fuelType    = '';
    public string $sortBy      = 'latest';
    public array  $favouriteIds = [];

    public function mount(): void
    {
        $this->loadFavourites();
    }

    private function loadFavourites(): void
    {
        $this->favouriteIds = auth()->check()
            ? auth()->user()->favouriteCars()->pluck('car_id')->map(fn($id) => (int) $id)->toArray()
            : [];
    }

    public function toggleFavourite(int $carId): void
    {
        if (!auth()->check()) {
            $this->redirectRoute('login');
            return;
        }

        $user = auth()->user();

        \Log::info('BEFORE toggle', ['carId' => $carId, 'favouriteIds' => $this->favouriteIds, 'inArray' => in_array($carId, $this->favouriteIds, true)]);

        if (in_array($carId, $this->favouriteIds, true)) {
            $user->favouriteCars()->detach($carId);
        } else {
            $user->favouriteCars()->attach($carId, ['notes' => null, 'added_at' => now()]);
        }

        $this->loadFavourites();

        \Log::info('AFTER loadFavourites', ['favouriteIds' => $this->favouriteIds]);

        $this->dispatch('favouriteToggled');
    }

    // Cuando cambia cualquier filtro reseteamos a la página 1
    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingFuelType(): void { $this->resetPage(); }
    public function updatingSortBy(): void   { $this->resetPage(); }

    public function render()
    {
        $query = Car::whereNotNull('published_at')
            ->with(['maker', 'model', 'primaryImage', 'city', 'fuelType']);

        // Búsqueda por nombre de marca o modelo
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('maker', fn($m) => $m->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('model', fn($m) => $m->where('name', 'like', "%{$this->search}%"));
            });
        }

        // Filtro por tipo de combustible
        if ($this->fuelType) {
            $query->ofFuelType($this->fuelType);
        }

        // Ordenación
        match ($this->sortBy) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default      => $query->latest(),
        };

        $cars = $query->paginate(12);

        $fuelTypes = Cache::remember('fuel_types', 3600, fn() => FuelType::all());

        return view('livewire.car-search', [
            'cars'         => $cars,
            'fuelTypes'    => $fuelTypes,
            'favouriteIds' => $this->favouriteIds,
        ]);
    }
}
