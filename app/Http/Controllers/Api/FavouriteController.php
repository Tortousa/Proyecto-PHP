<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponses;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// CRUD de favoritos del usuario autenticado.
// Usa la tabla pivote favourite_cars con columnas especiales:
//   - notes:    nota personal del usuario sobre ese coche
//   - added_at: fecha en que lo marcó como favorito
class FavouriteController extends Controller
{
    use ApiResponses;

    public function index(Request $request): JsonResponse
    {
        $favourites = $request->user()
            ->favouriteCars()
            ->with(['maker', 'model', 'primaryImage'])
            ->get()
            ->map(fn($car) => [
                'id'       => $car->id,
                'maker'    => $car->maker->name ?? null,
                'model'    => $car->model->name ?? null,
                'price'    => $car->price,
                'year'     => $car->year,
                'image'    => $car->primaryImage?->url,
                'notes'    => $car->pivot->notes,
                'added_at' => $car->pivot->added_at,
            ]);

        return $this->success($favourites);
    }

    public function show(Request $request, Car $car): JsonResponse
    {
        $pivot = $request->user()
            ->favouriteCars()
            ->where('car_id', $car->id)
            ->first();

        abort_unless($pivot, 404, 'Este coche no está en tus favoritos.');

        return $this->success([
            'id'       => $car->id,
            'maker'    => $car->maker->name ?? null,
            'model'    => $car->model->name ?? null,
            'price'    => $car->price,
            'notes'    => $pivot->pivot->notes,
            'added_at' => $pivot->pivot->added_at,
        ]);
    }

    public function store(Request $request, Car $car): JsonResponse
    {
        $user = $request->user();

        if ($user->favouriteCars()->where('car_id', $car->id)->exists()) {
            return $this->success([], ['message' => 'Ya está en favoritos.'], 409);
        }

        $request->validate(['notes' => 'nullable|string|max:500']);

        $user->favouriteCars()->attach($car->id, [
            'notes'    => $request->input('notes'),
            'added_at' => now(),
        ]);

        return $this->success(
            ['favourite' => true, 'notes' => $request->input('notes'), 'added_at' => now()->toDateTimeString()],
            ['message' => 'Añadido a favoritos.'],
            201
        );
    }

    public function update(Request $request, Car $car): JsonResponse
    {
        $user = $request->user();

        abort_unless(
            $user->favouriteCars()->where('car_id', $car->id)->exists(),
            404,
            'Este coche no está en tus favoritos.'
        );

        $request->validate(['notes' => 'nullable|string|max:500']);

        $user->favouriteCars()->updateExistingPivot($car->id, [
            'notes' => $request->input('notes'),
        ]);

        return $this->success(
            ['notes' => $request->input('notes')],
            ['message' => 'Nota actualizada.']
        );
    }

    public function destroy(Request $request, Car $car): JsonResponse
    {
        $user = $request->user();

        abort_unless(
            $user->favouriteCars()->where('car_id', $car->id)->exists(),
            404,
            'Este coche no está en tus favoritos.'
        );

        $user->favouriteCars()->detach($car->id);

        return $this->success([], ['message' => 'Eliminado de favoritos.']);
    }

    public function toggle(Request $request, Car $car): JsonResponse
    {
        $user   = $request->user();
        $exists = $user->favouriteCars()->where('car_id', $car->id)->exists();

        if ($exists) {
            $user->favouriteCars()->detach($car->id);
            return $this->success(['favourite' => false], ['message' => 'Eliminado de favoritos.']);
        }

        $user->favouriteCars()->attach($car->id, [
            'notes'    => $request->input('notes'),
            'added_at' => now(),
        ]);

        return $this->success(
            ['favourite' => true, 'notes' => $request->input('notes'), 'added_at' => now()->toDateTimeString()],
            ['message' => 'Añadido a favoritos.']
        );
    }
}
