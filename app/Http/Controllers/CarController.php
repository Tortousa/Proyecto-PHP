<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maker;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\City;
use App\Models\Model as CarModel;
use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Car::class);

        $cars = Car::where('user_id', Auth::id())->with(['maker', 'model'])->latest()->get();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $this->authorize('create', Car::class);

        $makers = Maker::all();
        $models = CarModel::all();
        $carTypes = CarType::all();
        $fuelTypes = FuelType::all();
        $cities = City::all();

        return view('cars.create', compact('makers', 'models', 'carTypes', 'fuelTypes', 'cities'));
    }

    public function store(StoreCarRequest $request)
    {
        $validated = $request->validated();

        $car = new Car($validated);
        $car->user_id = Auth::id();
        $car->published_at = now();
        $car->save();

        return redirect()->route('cars.index')->with('success', __('Coche creado con éxito'));
    }

    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        $makers = Maker::all();
        $models = CarModel::where('maker_id', $car->maker_id)->get();
        $carTypes = CarType::all();
        $fuelTypes = FuelType::all();
        $cities = City::all();

        return view('cars.edit', compact('car', 'makers', 'models', 'carTypes', 'fuelTypes', 'cities'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $validated = $request->validated();

        $car->update($validated);

        return redirect()->route('cars.index')->with('success', __('Coche actualizado con éxito'));
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();
        return redirect()->route('cars.index')->with('success', __('Coche eliminado'));
    }
}