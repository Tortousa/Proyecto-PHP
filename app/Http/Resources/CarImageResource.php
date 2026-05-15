<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Resource de imagen: expone id, url pública (calculada por el accessor) y posición.
// Se incluye en CarResource dentro del array 'imagenes'.
class CarImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'url'      => $this->url,
            'position' => $this->position,
        ];
    }
}
