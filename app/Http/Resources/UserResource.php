<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Transforma un User en la representación JSON de la API.
// Incluye estadísticas (total_coches, total_favoritos) que se calculan con loadCount()
// si están disponibles, o con count() de la relación en caso contrario.
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Preferimos los _count precalculados por loadCount() — evitan una consulta extra
        $totalCoches    = $this->cars_count ?? $this->cars->count();
        $totalFavoritos = $this->favouriteCars_count ?? $this->favouriteCars->count();

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'rol'   => $this->rol,

            'estadisticas' => [
                'total_coches'    => $totalCoches,
                'total_favoritos' => $totalFavoritos,
            ],

            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
