<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarImageResource extends JsonResource
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
            'car_id' => $this->car_id,
            'car' => $this->car ? [
                'id' => $this->car->id,
                'maker_id' => $this->car->maker_id,
                'model_id' => $this->car->model_id,
            ] : null,
            'image_path' => $this->image_path,
            'url' => $this->getImageUrl($this->image_path),
            'position' => $this->position,
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
