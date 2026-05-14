<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\CarImages as CarImagesModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CarImages extends Component
{
    use WithFileUploads;

    public Car $car;
    public $newImage;

    public function mount(Car $car): void
    {
        $this->car = $car;
    }

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
