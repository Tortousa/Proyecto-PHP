<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponses;
use App\Http\Resources\CarSummaryResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Importa el método $this->success() que envuelve toda respuesta en {data, meta}
    use ApiResponses;

    // Solo accesible con middleware rol:admin — devuelve todos los usuarios paginados
    public function index(): JsonResponse
    {
        $users = User::withCount(['cars', 'favouriteCars'])->paginate(15);

        return $this->success(UserResource::collection($users));
    }

    public function me(Request $request): JsonResponse
    {
        // loadCount añade cars_count y favourite_cars_count al modelo sin cargar los registros
        $user = $request->user()->loadCount(['cars', 'favouriteCars']);

        // data → perfil del usuario con sus estadísticas (UserResource incluye los counts)
        return $this->success(new UserResource($user));
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
