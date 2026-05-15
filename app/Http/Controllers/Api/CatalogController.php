<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponses;
use App\Http\Resources\CarTypeResource;
use App\Http\Resources\FuelTypeResource;
use App\Http\Resources\MakerResource;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Maker;
use Illuminate\Http\JsonResponse;

// Endpoints de catálogo — datos de referencia que el cliente necesita para poblar
// los selectores del formulario (marcas, combustibles, tipos de carrocería).
// Son públicos: no requieren autenticación porque son datos estáticos de la plataforma.
class CatalogController extends Controller
{
    // Importa el método $this->success() que envuelve toda respuesta en {data, meta}
    use ApiResponses;

    public function makers(): JsonResponse
    {
        $makers = Maker::all();

        // data → colección de marcas, meta.total → cuántas hay (útil para el cliente)
        return $this->success(MakerResource::collection($makers), ['total' => $makers->count()]);
    }

    public function fuelTypes(): JsonResponse
    {
        $types = FuelType::all();

        // data → colección de combustibles, meta.total → cuántos hay
        return $this->success(FuelTypeResource::collection($types), ['total' => $types->count()]);
    }

    public function carTypes(): JsonResponse
    {
        $types = CarType::all();

        // data → colección de tipos de carrocería, meta.total → cuántos hay
        return $this->success(CarTypeResource::collection($types), ['total' => $types->count()]);
    }
}
