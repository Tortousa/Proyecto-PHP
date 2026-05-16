<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\FuelType;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class CarSearch extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $fuelType     = '';
    public string $sortBy       = 'latest';
    public bool   $filtersOpen  = false;
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

        if (in_array($carId, $this->favouriteIds, true)) {
            $user->favouriteCars()->detach($carId);
        } else {
            $user->favouriteCars()->attach($carId, ['notes' => null, 'added_at' => now()]);
        }

        $this->loadFavourites();
        $this->dispatch('favouriteToggled');
    }

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingFuelType(): void { $this->resetPage(); }
    public function updatingSortBy(): void   { $this->resetPage(); }

    public function render()
    {
        $fuelTypes = Cache::remember('fuel_types', 3600, fn() => FuelType::all());

        $hasFilters = $this->search !== '' || $this->fuelType !== '' || $this->sortBy !== 'latest';

        if (!$hasFilters) {
            // Vista por defecto: cacheada 60s por página
            $page = $this->getPage();
            $cars = Cache::remember("cars_default_p{$page}", 60, function () {
                return Car::whereNotNull('published_at')
                    ->with(['maker', 'model', 'primaryImage', 'city', 'fuelType'])
                    ->latest()
                    ->paginate(12);
            });
        } else {
            // Con filtros: JOIN directo más eficiente que whereHas
            $query = Car::whereNotNull('published_at')
                ->with(['maker', 'model', 'primaryImage', 'city', 'fuelType'])
                ->join('makers',     'cars.maker_id', '=', 'makers.id')
                ->join('models', 'cars.model_id', '=', 'models.id')
                ->select('cars.*');

            if ($this->search !== '') {
                $term = "%{$this->search}%";
                $query->where(function ($q) use ($term) {
                    $q->where('makers.name',     'like', $term)
                      ->orWhere('models.name', 'like', $term);
                });
            }

            if ($this->fuelType !== '') {
                $query->ofFuelType($this->fuelType);
            }

            match ($this->sortBy) {
                'price_asc'  => $query->orderBy('cars.price'),
                'price_desc' => $query->orderByDesc('cars.price'),
                default      => $query->orderByDesc('cars.created_at'),
            };

            $cars = $query->paginate(12);
        }

        return view('livewire.car-search', [
            'cars'         => $cars,
            'fuelTypes'    => $fuelTypes,
            'favouriteIds' => $this->favouriteIds,
        ]);
    }
}
