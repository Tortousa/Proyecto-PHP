<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Resource de catálogo: expone solo id y name de cada tipo de combustible.
// Usado por CatalogController para el endpoint GET /api/catalog/fuel-types.
class FuelTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
