<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CarTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Sedan', 'SUV', 'Truck', 'Van', 'Coupe', 'Hatchback', 'Convertible', 'Minivan', 'Pickup', 'Sports Car', 'Wagon', 'Bicycle', 'Motorcycle', 'Other'])
        ];
    }
}
