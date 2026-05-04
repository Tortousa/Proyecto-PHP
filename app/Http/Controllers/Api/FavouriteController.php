<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Controlador para gestionar los favoritos del usuario autenticado.
// Usa la tabla pivote favourite_cars con columnas:
// - notes: nota personal del usuario sobre ese coche
// - added_at: fecha en que lo añadió a favoritos
class FavouriteController extends Controller
{
    /**
     * @OA\Post(
     *     path="/cars/{id}/favourite",
     *     tags={"Favoritos"},
     *     summary="Añadir o quitar un coche de favoritos (toggle)",
     *     description="Si el coche ya es favorito lo elimina. Si no lo es, lo añade guardando la fecha y una nota opcional en la tabla pivote.",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del coche", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="notes", type="string", example="Me gusta el color y el precio", description="Nota personal opcional")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Estado actualizado. Devuelve favourite: true/false"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=404, description="Coche no encontrado")
     * )
     */
    public function toggle(Request $request, Car $car): JsonResponse
    {
        $user   = $request->user();
        $exists = $user->favouriteCars()->where('car_id', $car->id)->exists();

        if ($exists) {
            // Ya era favorito — lo quitamos
            $user->favouriteCars()->detach($car->id);

            return response()->json([
                'favourite' => false,
                'message'   => 'Eliminado de favoritos.',
            ]);
        }

        // No era favorito — lo añadimos con los datos de la tabla pivote
        $user->favouriteCars()->attach($car->id, [
            'notes'    => $request->input('notes'),
            'added_at' => now(),
        ]);

        return response()->json([
            'favourite' => true,
            'message'   => 'Añadido a favoritos.',
            'notes'     => $request->input('notes'),
            'added_at'  => now()->toDateTimeString(),
        ]);
    }
}
