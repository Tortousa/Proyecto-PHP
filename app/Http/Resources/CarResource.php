<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'maker' => $this->maker ? [
                'id' => $this->maker->id,
                'name' => $this->maker->name,
            ] : null,
            'model' => $this->model ? [
                'id' => $this->model->id,
                'name' => $this->model->name,
            ] : null,
            'year' => $this->year,
            'price' => $this->price,
            'mileage' => $this->mileage,
            'vin' => $this->vin,
            'address' => $this->address,
            'phone' => $this->phone,
            'description' => $this->description,
            'car_type' => $this->carType ? [
                'id' => $this->carType->id,
                'name' => $this->carType->name,
            ] : null,
            'fuel_type' => $this->fuelType ? [
                'id' => $this->fuelType->id,
                'name' => $this->fuelType->name,
            ] : null,
            'city' => $this->city ? [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ] : null,
            'owner' => $this->owner ? [
                'id' => $this->owner->id,
                'name' => $this->owner->name,
                'email' => $this->owner->email,
            ] : null,
            'primary_image' => $this->primaryImage ? [
                'id' => $this->primaryImage->id,
                'image_path' => $this->primaryImage->image_path,
                'url' => $this->getImageUrl($this->primaryImage->image_path),
                'position' => $this->primaryImage->position,
            ] : null,
            'images' => CarImageResource::collection($this->images ?? []),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get full URL for image
     */
    private function getImageUrl($imagePath)
    {
        if (strpos($imagePath, 'http') === 0) {
            return $imagePath;
        }
        return asset('storage/' . $imagePath);
    }
}
