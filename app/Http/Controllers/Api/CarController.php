<?php

namespace App\Http\Controllers\Api;

use App\Events\CarPublished;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponses;
use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarSummaryResource;
use App\Models\Car;
use App\Services\CarImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// API de coches: listado público con filtros, detalle, y CRUD protegido con Sanctum.
class CarController extends Controller
{
    // Importa el método $this->success() que envuelve toda respuesta en {data, meta}
    use ApiResponses;

    public function __construct(private CarImageService $imageService) {}

    public function index(Request $request): JsonResponse
    {
        $query = Car::whereNotNull('published_at');

        if ($request->input('maker')) {
            $query->byMaker($request->input('maker'));
        }

        if ($request->input('fuel_type')) {
            $query->ofFuelType($request->input('fuel_type'));
        }

        if ($request->input('min_price') && $request->input('max_price')) {
            $query->priceBetween($request->input('min_price'), $request->input('max_price'));
        }

        if ($request->input('state')) {
            $query->inState($request->input('state'));
        }

        $cars = $query->with(['maker', 'model', 'carType', 'city', 'primaryImage'])
            ->latest()
            ->paginate(15);

        // La paginación de Laravel ya genera automáticamente {data, links, meta}
        // por eso no usamos $this->success() aquí — el formato ya es correcto
        return CarSummaryResource::collection($cars)->response();
    }

    public function show(Car $car): JsonResponse
    {
        // load() carga las relaciones para que CarResource pueda incluirlas en la respuesta
        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'owner', 'primaryImage', 'images']);

        // data → coche completo transformado por CarResource (incluye marca, modelo, imágenes...)
        return $this->success(new CarResource($car));
    }

    public function store(StoreCarRequest $request): JsonResponse
    {
        $car = new Car($request->validated());
        $car->user_id      = Auth::id();
        $car->published_at = now();
        $car->save();

        if ($request->hasFile('images')) {
            $this->imageService->save($car, (array) $request->file('images'));
        }

        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'images', 'owner']);

        // El evento dispara NotifyCarPublished → SendCarPublishedEmailJob (cola)
        CarPublished::dispatch($car);

        // data → coche recién creado, meta → mensaje confirmación, 201 → HTTP Created
        return $this->success(new CarResource($car), ['message' => 'Coche publicado correctamente.'], 201);
    }

    public function update(UpdateCarRequest $request, Car $car): JsonResponse
    {
        $this->authorize('update', $car);

        $car->update($request->validated());

        if ($request->hasFile('images')) {
            $this->imageService->save($car, (array) $request->file('images'));
        }

        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'images']);

        // data → coche actualizado con sus nuevos valores
        return $this->success(new CarResource($car));
    }

    public function destroy(Car $car): JsonResponse
    {
        $this->authorize('delete', $car);

        $car->delete();

        // data → null porque el coche ya no existe; meta → confirmación del borrado
        return $this->success(null, ['message' => 'Coche eliminado correctamente.']);
    }
}
