<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImages;
use Illuminate\Database\Seeder;

class CarImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add generic images to cars that don't have any images
        $carsWithoutImages = Car::doesntHave('images')->get();

        foreach ($carsWithoutImages as $car) {
            CarImages::create([
                'car_id' => $car->id,
                'image_path' => 'https://via.placeholder.com/800x600?text=' . urlencode($car->maker->name . ' ' . $car->model->name),
                'position' => 1,
            ]);
        }
    }
}