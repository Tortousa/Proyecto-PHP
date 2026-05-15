<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\JsonResponse;

// Trait que estandariza el formato JSON de todas las respuestas de la API.
// Todos los controladores API usan este trait con "use ApiResponses".
//
// Formato resultante en todas las respuestas:
// {
//   "data": { ... },   → el contenido real (recurso, colección, token, etc.)
//   "meta": { ... }    → información extra (mensajes, totales, paginación...)
// }
//
// Ventaja: si mañana quieres cambiar el formato (añadir "status", "timestamp"...)
// solo tienes que tocar este único método, no los 5 controladores.
trait ApiResponses
{
    // $data   → lo que devuelve el endpoint (un Resource, un array, null en DELETE...)
    // $meta   → información auxiliar: mensajes de texto, totales, etc.
    // $status → código HTTP (200 por defecto, 201 para creación, 401 para no autorizado...)
    protected function success(mixed $data = null, array $meta = [], int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data, 'meta' => $meta], $status);
    }
}
