<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            // These will be overwritten by the parent Room relationship
            'room_id' => Room::factory(),
            'hotel_id' => function (array $attributes) {
                return Room::find($attributes['room_id'])->hotel_id;
            },
            'guest_name' => $this->faker->name,
            'check_in' => $this->faker->dateTimeBetween('now', '+1 month'),
            'check_out' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}