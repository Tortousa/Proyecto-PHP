<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImages;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CarType::factory()
            ->sequence(
                ['name' => 'Sedan',],
                ['name' => 'Hatchback',],
                ['name' => 'SUV',],
                ['name' => 'Pickup Truck',],
                ['name' => 'Minivan',],
                ['name' => 'Jeep',],
                ['name' => 'Coupe',],
                ['name' => 'Crossover',],
                ['name' => 'Sports Car',],
            )
            ->count(9)
            ->create();

        FuelType::factory()
            ->sequence(
                ['name' => 'Gasoline',],
                ['name' => 'Diesel',],
                ['name' => 'Electric',],
                ['name' => 'Hybrid',],
            )
            ->count(4)
            ->create();

        $states = [
            'California' => ['Los Angeles', 'San Francisco', 'San Diego'],
            'New York' => ['New York City', 'Albany', 'Buffalo'],
        ];


        foreach ($states as $state => $cities) {
            State::factory()
                ->state(['name' => $state])
                ->has(
                    City::factory()
                    ->count(count($cities))
                    ->sequence(...array_map(fn($city) => ['name' => $city], $cities))
                )
                ->create();
        }

        $makers = [
            'Toyota' => ['Carmy', 'Corolla', 'RAV4'],
            'Ford' => ['Escape', 'Mustang', 'F-150'],
        ];


        foreach ($makers as $maker => $models) {
            Maker::factory()
                ->state(['name' => $maker])
                ->has(
                    Model::factory()
                        ->count(count($models))
                        ->sequence(...array_map(fn($model) => ['name' => $model], $models))
                )
                ->create();
        }

        User::factory()
            ->count(3)
            ->create();

        User::factory()
            ->count(2)
            ->has(
                Car::factory()
                ->count(50)
                ->has(
                    CarImages::factory()
                    ->count(5)
                    ->sequence(fn(Sequence $sequence) => ['position' => $sequence->index % 5 + 1]),
                    'images'
                )
                ->hasFeatures(),
                'favouriteCars'
            )
            ->create();
    }
}
