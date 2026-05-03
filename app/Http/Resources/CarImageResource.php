<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $url = asset('storage/' . $this->image_path);

        return [
            'id'       => $this->id,
            'url'      => $url,
            'position' => $this->position,
        ];
    }
}
