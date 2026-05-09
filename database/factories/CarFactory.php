<?php

namespace Database\Factories;

use App\Models\CarType;
use App\Models\Car;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\User;
use App\Services\CarImageService;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarModel;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'maker_id' => Maker::inRandomOrder()->first()->id,
            'model_id' => function(array $attributes) {
                return CarModel::where('maker_id', $attributes['maker_id'])
                    ->inRandomOrder()->first()->id;
            },
            'year' => fake()->year(),
            'price' => ((int)fake()->randomFloat(2, 5, 100)) * 1000,
            'vin' => strtoupper(Str::random(17)),
            'mileage' => ((int)fake()->randomFloat(2, 5, 500)) * 1000,
            'car_type_id' => CarType::inRandomOrder()->first()->id,
            'fuel_type_id' => FuelType::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->text(2000),
            'published_at' => fake()->optional(0.9)
                ->dateTimeBetween('-1 month', '+1 day')
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Car $car) {
            // Cargamos el maker para que el servicio genere una URL con la marca real
            $car->load('maker');
            $car->images()->create([
                'image_path' => app(CarImageService::class)->placeholder($car),
                'position'   => 1,
            ]);
        });
    }
}
