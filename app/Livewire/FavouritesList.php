<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

// Componente Livewire — gestión de favoritos del usuario autenticado.
// Permite ver, editar la nota personal y eliminar favoritos sin recargar la página.
// Es un CRUD completo: Read (listado), Update (editar nota), Delete (eliminar).
class FavouritesList extends Component
{
    // ID del favorito que se está editando en este momento (null = ninguno)
    public ?int $editingId   = null;
    public string $editingNote = '';

    #[On('favouriteToggled')]
    public function refresh(): void {}

    // Abre el modo edición para un coche concreto y carga la nota actual
    public function startEdit(int $carId): void
    {
        $this->editingId   = $carId;
        $pivot             = auth()->user()->favouriteCars()->where('car_id', $carId)->first();
        $this->editingNote = $pivot?->pivot->notes ?? '';
    }

    // Cancela la edición sin guardar
    public function cancelEdit(): void
    {
        $this->editingId = null;
    }

    // Guarda la nota personal en la tabla pivote favourite_cars
    public function saveNote(): void
    {
        auth()->user()->favouriteCars()->updateExistingPivot($this->editingId, [
            'notes' => $this->editingNote,
        ]);

        $this->editingId = null;
    }

    // Elimina el coche de favoritos (detach en la tabla pivote)
    public function remove(int $carId): void
    {
        auth()->user()->favouriteCars()->detach($carId);
    }

    public function render()
    {
        // Cargamos los favoritos con los datos del coche y los del pivote (nota + fecha)
        $favourites = auth()->user()
            ->favouriteCars()
            ->with(['maker', 'model', 'primaryImage'])
            ->withPivot(['notes', 'added_at'])
            ->orderByPivot('added_at', 'desc')
            ->get();

        return view('livewire.favourites-list', compact('favourites'));
    }
}
