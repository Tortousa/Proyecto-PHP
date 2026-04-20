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
    public function index(Request $request)
    {
        $this->authorize('viewAny', Car::class);

        // Empezamos la consulta, pero NO la ejecutamos todavía
        $query = Car::query();

        // Aplicamos la restricción por usuario si no es admin
        if (!Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        }

        // Aplicamos los scopes solo si el parámetro existe en la URL
        if ($request->filled('maker')) {
            $query->byMaker($request->maker);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        if ($request->filled('fuel_type')) {
            $query->ofFuelType($request->fuel_type);
        }

        // Al final, ejecutamos la consulta con las relaciones y paginación
        $cars = $query->with(['maker', 'model', 'primaryImage'])
                      ->latest()
                      ->paginate(15); // Requisito extra: ¡Paginación!

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

    public function show(Car $car)
    {
        $this->authorize('view', $car);

        return view('cars.show', compact('car'));
    }

    public function store(StoreCarRequest $request)
    {
        $validated = $request->validated();

        $car = new Car($validated);
        $car->user_id = Auth::id();
        $car->published_at = now();
        $car->save();

        // Handle uploaded images (optional)
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if (!$file) continue;
                $path = $file->store('cars', 'public');
                $position = $car->images()->count() + 1;
                $car->images()->create([
                    'image_path' => $path,
                    'position' => $position,
                ]);
            }
        }

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
        $this->authorize('update', $car);

        $validated = $request->validated();

        $car->update($validated);

        // Allow adding new images on update
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if (!$file) continue;
                $path = $file->store('cars', 'public');
                $position = $car->images()->count() + 1;
                $car->images()->create([
                    'image_path' => $path,
                    'position' => $position,
                ]);
            }
        }

        return redirect()->route('cars.index')->with('success', __('Coche actualizado con éxito'));
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();
        return redirect()->route('cars.index')->with('success', __('Coche eliminado'));
    }
}