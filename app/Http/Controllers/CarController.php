<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maker;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\City;
use App\Models\Model as CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::where('user_id', Auth::id())->with(['maker', 'model'])->latest()->get();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $makers = Maker::all();
        $models = CarModel::all();
        $carTypes = CarType::all();
        $fuelTypes = FuelType::all();
        $cities = City::all();

        return view('cars.create', compact('makers', 'models', 'carTypes', 'fuelTypes', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'maker_id' => 'required|exists:makers,id',
            'model_id' => 'required|exists:models,id',
            'city_id' => 'required|exists:cities,id',
            'car_type_id' => 'required|exists:car_types,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'vin' => 'required|string|max:255',
            'phone' => 'required|string|max:45',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $car = new Car($validated);
        $car->user_id = Auth::id();
        $car->published_at = now();
        $car->save();

        return redirect()->route('cars.index')->with('success', __('Coche creado con éxito'));
    }

    public function edit(Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403);
        }

        $makers = Maker::all();
        $models = CarModel::where('maker_id', $car->maker_id)->get();
        $carTypes = CarType::all();
        $fuelTypes = FuelType::all();
        $cities = City::all();

        return view('cars.edit', compact('car', 'makers', 'models', 'carTypes', 'fuelTypes', 'cities'));
    }

    public function update(Request $request, Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'maker_id' => 'required|exists:makers,id',
            'model_id' => 'required|exists:models,id',
            'city_id' => 'required|exists:cities,id',
            'car_type_id' => 'required|exists:car_types,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'vin' => 'required|string|max:255',
            'phone' => 'required|string|max:45',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $car->update($validated);

        return redirect()->route('cars.index')->with('success', __('Coche actualizado con éxito'));
    }

    public function destroy(Car $car)
    {
        if ($car->user_id !== Auth::id()) {
            abort(403);
        }

        $car->delete();
        return redirect()->route('cars.index')->with('success', __('Coche eliminado'));
    }
}