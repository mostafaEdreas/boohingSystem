<?php

namespace App\Repositories;  

use App\Models\Room;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

class RoomRepository
{
    protected $model = Room::class;

    public function getStats()
    {
        $now = now()->format('Y-m-d');
        $busyRoomsCount = $this->model::whereHas('reservations', function ($query) use ($now) {
            $query->where('checkout_date', '<=', $now)
                ->where('checkout_date', '>=', $now);
        })->count();
        return [
            'total_rooms' =>  $this->model::sum('rooms_count') ?? 0,
            'busy_rooms'       => $busyRoomsCount ?? 0,
            'available_rooms'   => $this->model::sum('available_rooms') ?? 0,
        ];
    }

    public function listWithHotelNameAndID(Request $request , array $columns = ['*']): Paginator
    {
        return $this->model::select($columns)
            ->with('hotel:id,name')
            ->filter($request)
            ->paginate(10);
    }

    public function list(Request $request ,array $columns = ['*'],array $relations = []): Paginator
    {
        return $this->model::select($columns)
             ->filter($request)
            ->with($relations)
            ->paginate(10);
    }
    public function createRoom(array $data): ?Room
    {
        return $this->model::create($data);
    }

   public function availableRoomsCount(): int
    {
        // Sums the 'available_rooms' column from the associated rooms
        return (int) $this->model::sum('available_rooms');
    }

    public function roomsCount(): int
    {
        // Sums the 'available_rooms' column from the associated rooms
        return (int) $this->model::count();
    }
}