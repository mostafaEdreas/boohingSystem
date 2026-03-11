<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\RoomRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class RoomService
{
    protected $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function getRoomDashboardCards()
    {
      
        
        $stats = Cache::remember("room_stats", now()->addHours(1), function () {
            return $this->roomRepository->getStats();
        });

        // 2. Prepare the Card Array
        return [
            [
                'title'    => 'Total Rooms',
                'value'    => number_format($stats['total_rooms']),
                'color'    => 'primary',
                'svg_path' => 'M3.75 6A2.25 2.25 0 001.5 8.25v10.5a.75.75 0 001.5 0v-1.5h18v1.5a.75.75 0 001.5 0V8.25A2.25 2.25 0 0020.25 6H3.75zM3 13.5v-3.75c0-.414.336-.75.75-.75H9c.414 0 .75.336.75.75v3.75h-6.75zm10.5 0v-3.75c0-.414.336-.75.75-.75h5.25c.414 0 .75.336.75.75v3.75h-6.75z' // Bed Icon
            ],
            [
                'title'    => 'Available Rooms',
                'value'    => number_format($stats['available_rooms']),
                'color'    => 'success',
                'svg_path' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' // Checkmark Circle
            ],
            [
                'title'    => 'Busy Rooms',
                'value'    => number_format($stats['busy_rooms']),
                'color'    => 'warning', 
                // User/Occupied Icon
                'svg_path' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'
            ],
           
        ];
    }


    /**
     * Handles the business logic for listing rooms.
     */
    public function listRooms(Request $request ,bool $withHotel = true , array $columns =[],  array $relations =[]): Paginator
    {
        if ($withHotel) {
            return $this->roomRepository->listWithHotelNameAndID($request, $columns);
        }

        return $this->roomRepository->list($request, $columns , $relations);
    }

    /**
     * Logic for creating a room (e.g., sending emails or logging).
     */
    public function createNewRoom(array $data): ?Room
    {
        // Business Rule: Ensure available_rooms doesn't exceed a certain limit if needed
        return $this->roomRepository->createRoom($data);
    }

   
}