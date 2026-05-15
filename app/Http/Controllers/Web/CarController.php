<?php

namespace App\Http\Controllers\Web;

use App\Events\CarPublished;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\CarModel;
use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Services\CarImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// CRUD web de anuncios de coches (sección MyCars).
// Los permisos se controlan a través de CarPolicy — el dueño gestiona sus propios anuncios
// y el admin puede gestionar todos.
class CarController extends Controller
{
    public function __construct(private CarImageService $imageService) {}
    // Lista los coches del usuario autenticado con filtros opcionales.
    // El admin ve todos; un usuario normal solo ve los suyos.
    public function index(Request $request)
    {
        $query = Car::query();

        if (!Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('maker')) {
            $query->byMaker($request->maker);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        if ($request->filled('fuel_type')) {
            $query->ofFuelType($request->fuel_type);
        }

        $cars = $query->with(['maker', 'model', 'primaryImage'])
                      ->latest()
                      ->paginate(15);

        return view('cars.index', compact('cars'));
    }

    // Formulario de creación — cargamos los selectores del formulario
    public function create()
    {
        $this->authorize('create', Car::class);

        $makers    = Maker::all();
        $models    = CarModel::all();
        $carTypes  = CarType::all();
        $fuelTypes = FuelType::all();
        $cities    = City::all();

        return view('cars.create', compact('makers', 'models', 'carTypes', 'fuelTypes', 'cities'));
    }

    // Detalle de un coche — accesible sin autenticación
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    // Guarda el nuevo coche y procesa las imágenes si se han adjuntado
    public function store(StoreCarRequest $request)
    {
        $car            = new Car($request->validated());
        $car->user_id   = Auth::id();
        $car->published_at = now();
        $car->save();

        if ($request->hasFile('images')) {
            $this->imageService->save($car, (array) $request->file('images'));
        }

        CarPublished::dispatch($car);

        return redirect()->route('cars.index')->with('success', __('Coche creado con éxito'));
    }

    // Formulario de edición — cargamos los modelos del fabricante seleccionado
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        $makers    = Maker::all();
        $models    = CarModel::where('maker_id', $car->maker_id)->get();
        $carTypes  = CarType::all();
        $fuelTypes = FuelType::all();
        $cities    = City::all();

        return view('cars.edit', compact('car', 'makers', 'models', 'carTypes', 'fuelTypes', 'cities'));
    }

    // Actualiza los datos y añade nuevas imágenes si se han subido
    public function update(UpdateCarRequest $request, Car $car)
    {
        $this->authorize('update', $car);

        $car->update($request->validated());

        if ($request->hasFile('images')) {
            $this->imageService->save($car, (array) $request->file('images'));
        }

        return redirect()->route('cars.index')->with('success', __('Coche actualizado con éxito'));
    }

    // Soft delete — el registro permanece en BD por si el admin necesita recuperarlo
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();

        return redirect()->route('cars.index')->with('success', __('Coche eliminado'));
    }


}
