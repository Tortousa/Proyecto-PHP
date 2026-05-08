<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Http\UploadedFile;

// Servicio centralizado para todo lo relacionado con imágenes de coches.
// Cualquier parte del proyecto que necesite guardar o generar imágenes pasa por aquí,
// así si en el futuro cambiamos de proveedor (LoremFlickr → Unsplash, S3, etc.)
// solo hay que tocar este archivo.
class CarImageService
{
    // Guarda cada archivo subido en storage y crea su registro en la BD.
    // Usado por Web\CarController y Api\CarController.
    public function save(Car $car, array $files): void
    {
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) continue;

            $path = $file->store('cars', 'public');

            $car->images()->create([
                'image_path' => $path,
                'position'   => $car->images()->count() + 1,
            ]);
        }
    }

    // Genera una URL de placeholder con foto real de coche via LoremFlickr.
    // No requiere API key. El parámetro lock garantiza que el mismo coche
    // siempre recibe la misma foto.
    public function placeholder(Car $car): string
    {
        $makerSlug = strtolower(str_replace(' ', ',', $car->maker->name));

        return "https://loremflickr.com/800/600/car,{$makerSlug}?lock={$car->id}";
    }
}
