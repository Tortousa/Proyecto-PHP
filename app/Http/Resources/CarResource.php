<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imagenPrincipal = $this->primaryImage
            ? asset('storage/' . $this->primaryImage->image_path)
            : null;

        return [
            'id'          => $this->id,
            'price'       => $this->price,
            'year'        => $this->year,
            'mileage'     => $this->mileage,
            'vin'         => $this->vin,
            'description' => $this->description,
            'published_at'=> $this->published_at,

            'vehiculo' => [
                'maker'     => $this->maker->name,
                'model'     => $this->model->name,
                'car_type'  => $this->carType->name,
                'fuel_type' => $this->fuelType->name,
            ],

            'contacto' => [
                'phone'   => $this->phone,
                'address' => $this->address,
                'city'    => $this->city->name,
            ],

            'owner'          => new UserResource($this->owner),
            'imagen_principal' => $imagenPrincipal,
            'imagenes'       => CarImageResource::collection($this->images),

            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
