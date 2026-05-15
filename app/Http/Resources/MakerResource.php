<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Resource de catálogo: expone solo id y name de cada fabricante.
// Usado por CatalogController para el endpoint GET /api/catalog/makers.
class MakerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
