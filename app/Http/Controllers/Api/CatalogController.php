<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarTypeResource;
use App\Http\Resources\FuelTypeResource;
use App\Http\Resources\MakerResource;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Maker;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function makers(): JsonResponse
    {
        return response()->json(MakerResource::collection(Maker::all()));
    }

    public function fuelTypes(): JsonResponse
    {
        return response()->json(FuelTypeResource::collection(FuelType::all()));
    }

    public function carTypes(): JsonResponse
    {
        return response()->json(CarTypeResource::collection(CarType::all()));
    }
}
