<?php

namespace App\Http\Controllers\Api;

use App\Events\CarPublished;
use App\Http\Controllers\Controller;
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
    public function __construct(private CarImageService $imageService) {}
    /**
     * @OA\Get(
     *     path="/cars",
     *     tags={"Coches"},
     *     summary="Listado público de coches con filtros opcionales",
     *     @OA\Parameter(name="maker", in="query", description="Filtrar por marca", @OA\Schema(type="string")),
     *     @OA\Parameter(name="fuel_type", in="query", description="Filtrar por tipo de combustible (ID)", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="min_price", in="query", description="Precio mínimo", @OA\Schema(type="number")),
     *     @OA\Parameter(name="max_price", in="query", description="Precio máximo", @OA\Schema(type="number")),
     *     @OA\Parameter(name="state", in="query", description="Filtrar por provincia (ID)", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Listado paginado de coches")
     * )
     */
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

        return CarSummaryResource::collection($cars)->response();
    }

    /**
     * @OA\Get(
     *     path="/cars/{id}",
     *     tags={"Coches"},
     *     summary="Detalle completo de un coche",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Datos completos del coche"),
     *     @OA\Response(response=404, description="Coche no encontrado")
     * )
     */
    public function show(Car $car): JsonResponse
    {
        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'owner', 'primaryImage', 'images']);

        return response()->json(new CarResource($car));


        
    }

    /**
     * @OA\Post(
     *     path="/cars",
     *     tags={"Coches"},
     *     summary="Publicar un nuevo coche (requiere autenticación)",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"maker_id","model_id","city_id","car_type_id","fuel_type_id","year","price","mileage","vin","phone","address"},
     *             @OA\Property(property="maker_id", type="integer", example=1),
     *             @OA\Property(property="model_id", type="integer", example=3),
     *             @OA\Property(property="city_id", type="integer", example=5),
     *             @OA\Property(property="car_type_id", type="integer", example=1),
     *             @OA\Property(property="fuel_type_id", type="integer", example=2),
     *             @OA\Property(property="year", type="integer", example=2020),
     *             @OA\Property(property="price", type="number", example=15000),
     *             @OA\Property(property="mileage", type="integer", example=45000),
     *             @OA\Property(property="vin", type="string", example="1HGCM82633A123456"),
     *             @OA\Property(property="phone", type="string", example="612345678"),
     *             @OA\Property(property="address", type="string", example="Calle Mayor 1")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Coche publicado correctamente"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
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

        return response()->json(new CarResource($car), 201);
    }

    /**
     * @OA\Put(
     *     path="/cars/{id}",
     *     tags={"Coches"},
     *     summary="Actualizar un coche propio (requiere autenticación)",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Coche actualizado"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="Coche no encontrado")
     * )
     */
    public function update(UpdateCarRequest $request, Car $car): JsonResponse
    {
        $this->authorize('update', $car);

        $car->update($request->validated());

        if ($request->hasFile('images')) {
            $this->imageService->save($car, (array) $request->file('images'));
        }

        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'images']);

        return response()->json(new CarResource($car));
    }

    /**
     * @OA\Delete(
     *     path="/cars/{id}",
     *     tags={"Coches"},
     *     summary="Eliminar un coche propio (requiere autenticación)",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Coche eliminado"),
     *     @OA\Response(response=403, description="No autorizado"),
     *     @OA\Response(response=404, description="Coche no encontrado")
     * )
     */
    public function destroy(Car $car): JsonResponse
    {
        $this->authorize('delete', $car);

        $car->delete();

        return response()->json(['message' => 'Coche eliminado correctamente.']);
    }
}
