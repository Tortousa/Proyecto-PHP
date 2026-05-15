<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Versión compacta de CarResource para listados paginados.
// Solo expone los campos necesarios para mostrar una tarjeta de coche en el índice.
// CarResource (detalle) incluye además owner, descripción, todas las imágenes, etc.
class CarSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'precio'  => $this->price,
            'anyo'    => $this->year,
            'km'      => $this->mileage,

            'vehiculo' => [
                'maker'    => $this->maker->name,
                'model'    => $this->model->name,
                'car_type' => $this->carType->name,
            ],

            'ubicacion'        => $this->city->name,
            'imagen_principal' => $this->primaryImage?->url,
        ];
    }
}
