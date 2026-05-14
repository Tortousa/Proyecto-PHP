<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImages;
use App\Services\CarImageService;
use Illuminate\Database\Seeder;

class CarImageSeeder extends Seeder
{
    public function __construct(private CarImageService $imageService) {}

    public function run(): void
    {
        // Añadimos una imagen placeholder a los coches que no tienen ninguna
        $carsWithoutImages = Car::doesntHave('images')->with('maker')->get();

        foreach ($carsWithoutImages as $car) {
            CarImages::create([
                'car_id'     => $car->id,
                'image_path' => $this->imageService->placeholder($car),
                'position'   => 1,
            ]);
        }
    }
}
