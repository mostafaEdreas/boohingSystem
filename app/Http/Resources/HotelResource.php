<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'country' => $this->country,
            'rating' => $this->rating,
        ];

        if ($this->relationLoaded('rooms')) {
            $data['rooms'] = RoomResource::collection($this->rooms);
        }

        return $data;
    }
}
