<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{

   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   
    public function definition(): array
    {
        $total = fake()->numberBetween(10, 20);
        return [
            'hotel_id' => Hotel::factory(), // Creates a new hotel if one isn't provided
            'name' => fake()->randomElement(['Standard', 'Deluxe', 'Executive Suite', 'Penthouse']) . ' ' . fake()->numberBetween(100, 500),
            'price_per_night' => fake()->randomFloat(2, 50, 500),
            'max_occupancy' => fake()->numberBetween(1, 4),
            'available_rooms' => $total,
            'rooms_count' => $total
        ];
    }
}
