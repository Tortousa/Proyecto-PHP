<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarSummaryResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->loadCount(['cars', 'favouriteCars']);

        return response()->json(new UserResource($user));
    }

    public function favourites(Request $request): JsonResponse
    {
        $cars = $request->user()
            ->favouriteCars()
            ->with(['maker', 'model', 'carType', 'city', 'primaryImage'])
            ->paginate(15);

        // Devolvemos el resource directamente para incluir {data, links, meta} en la respuesta
        return CarSummaryResource::collection($cars)->response();
    }
}
