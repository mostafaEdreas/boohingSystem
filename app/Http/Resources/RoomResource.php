<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'hotel_id' => $this->hotel_id,
            'name' => $this->name,
            'price_per_night' => $this->price_per_night,
            'max_occupancy' => $this->max_occupancy,
            'available_rooms' => $this->available_rooms,
            'rooms_count' => $this->rooms_count,
        ];

        if (isset($this->total_calculated_price)) {
            $data['total_price'] = $this->total_calculated_price;
        }

        return $data;
    }
}
