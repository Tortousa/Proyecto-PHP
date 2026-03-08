<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource;

class CarController
{
    /**
     * CRUD 1: Display a listing of published cars
     * GET /api/cars
     */
    public function index(Request $request)
    {
        $cars = Car::where('published_at', '!=', null)
            ->with(['maker', 'model', 'carType', 'fuelType', 'city', 'owner', 'primaryImage', 'images'])
            ->when($request->input('maker_id'), function ($query) use ($request) {
                return $query->where('maker_id', $request->input('maker_id'));
            })
            ->when($request->input('model_id'), function ($query) use ($request) {
                return $query->where('model_id', $request->input('model_id'));
            })
            ->when($request->input('city_id'), function ($query) use ($request) {
                return $query->where('city_id', $request->input('city_id'));
            })
            ->when($request->input('price_min'), function ($query) use ($request) {
                return $query->where('price', '>=', $request->input('price_min'));
            })
            ->when($request->input('price_max'), function ($query) use ($request) {
                return $query->where('price', '<=', $request->input('price_max'));
            })
            ->latest('published_at')
            ->paginate($request->input('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Cars retrieved successfully',
            'data' => CarResource::collection($cars),
            'pagination' => [
                'total' => $cars->total(),
                'per_page' => $cars->perPage(),
                'current_page' => $cars->currentPage(),
                'last_page' => $cars->lastPage(),
            ]
        ], 200);
    }

    /**
     * Display a specific published car
     * GET /api/cars/{id}
     */
    public function show(Car $car)
    {
        if (!$car->published_at) {
            return response()->json([
                'success' => false,
                'message' => 'Car not found'
            ], 404);
        }

        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'owner', 'images', 'features']);

        return response()->json([
            'success' => true,
            'message' => 'Car retrieved successfully',
            'data' => new CarResource($car)
        ], 200);
    }
}
