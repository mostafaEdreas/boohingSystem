<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Hotels with Rooms and Reservations
        $hotels = Hotel::factory()
            ->count(10)
            ->has(
               Room::factory()
                    ->count(5)
                    ->has(
                       Reservation::factory()
                            ->count(2)
                            ->state(function (array $attributes,Room $room) {
                                return ['hotel_id' => $room->hotel_id];
                            })
                    )
            )
            ->create();

        // 2. Fix the "Available Rooms" column to be REAL
        Room::all()->each(function ($room) {
            $now = now();
            
            // Count how many reservations are active RIGHT NOW for this room
            $busyCount = $room->reservations()
                ->where('checkin_date', '<=', $now)
                ->where('checkout_date', '>=', $now)
                ->count();

            // Update the column: Available = Total Capacity - Active Bookings
            $room->update([
                'available_rooms' => max(0, $room->rooms_count - $busyCount)
            ]);
        });
    }
}
