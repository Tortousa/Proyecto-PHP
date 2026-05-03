<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
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
