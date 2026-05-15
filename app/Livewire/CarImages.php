<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\CarImages as CarImagesModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

// Componente Livewire — gestión de imágenes de un coche concreto.
// Permite subir nuevas imágenes, marcar una como principal y eliminar las existentes.
// Se usa en la vista de edición del anuncio (cars/edit).
class CarImages extends Component
{
    use WithFileUploads;

    public Car $car;
    public $newImage;

    public function mount(Car $car): void
    {
        $this->car = $car;
    }

    // Valida, guarda en storage/public/cars y crea el registro en car_images.
    // La posición se asigna al final de la lista para no alterar el orden existente.
    public function upload(): void
    {
        $this->validate(['newImage' => 'required|image|max:2048']);

        $path = $this->newImage->store('cars', 'public');

        $maxPosition = $this->car->images()->max('position') ?? 0;

        $this->car->images()->create([
            'image_path' => $path,
            'position'   => $maxPosition + 1,
        ]);

        $this->newImage = null;
        $this->car->refresh();
    }

    // Marca una imagen como principal poniendo su posición a 0 (Update del CRUD)
    public function setPrimary(int $imageId): void
    {
        // Empuja todas las imágenes del coche una posición hacia arriba
        $this->car->images()->increment('position');

        // La imagen seleccionada pasa a posición 0 → primaryImage la recoge
        CarImagesModel::where('id', $imageId)
            ->where('car_id', $this->car->id)
            ->update(['position' => 0]);

        $this->car->refresh();
    }

    // Elimina el archivo físico del disco solo si es una imagen local (no placeholder externo).
    public function delete(int $imageId): void
    {
        $image = CarImagesModel::findOrFail($imageId);

        if (!str_starts_with($image->image_path, 'http')) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();
        $this->car->refresh();
    }

    public function render()
    {
        return view('livewire.car-images', [
            'images' => $this->car->images()->orderBy('position')->get(),
        ]);
    }
}
