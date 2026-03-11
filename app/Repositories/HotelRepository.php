<?php
namespace App\Repositories;

use App\Models\Hotel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HotelRepository
{

    protected $model = Hotel::class;

    public function getStats()
    {
        return [
            'total_hotels'    => $this->model::count(),
            'avg_rating'      => round($this->model::avg('rating'), 1) ?: 0,
            'total_cities'    => $this->model::distinct('city')->count(),
            'total_countries' => $this->model::distinct('country')->count(),
            'top_country'     => $this->model::select('country')
                ->groupBy('country')
                ->orderByRaw('COUNT(*) DESC')
                ->first()?->country ?? 'N/A',
        ];
    }

    public function list(Request $request, array $relations = [], array $columns = ['*']): Paginator
    {
        return $this->model::select($columns)
            ->filter($request)
            ->with($relations)->paginate(10);
    }

    public function createHotel(array $data): ?Hotel
    {
        return $this->model::create($data);
    }

    public function hotelCount(): int
    {
        return $this->model::count();
    }

    public function findById($id, array $relations = []): ?Hotel
    {
        return $this->model::with($relations)->findOrFail($id);
    }

    public function update($id, array $data): ?Hotel
    {
        $hotel = $this->model::findOrFail($id);
        $hotel->update($data);
        return $hotel->refresh();
    }

    public function delete($id)
    {
        $hotel = $this->model::findOrFail($id);
        return $hotel->delete();
    }

    public function hotelCollection(array $columns = ['*']): Collection
    {
        return $this->model::select($columns)->get();
    }

    public function search(Request $request): Paginator
    {
        // 1. Calculate Stay Duration (Nights)
        $nights = 1;
        if ($request->filled(['res_checkin_date', 'res_checkout_date'])) {
            $checkIn  = \Carbon\Carbon::parse($request->res_checkin_date);
            $checkOut = \Carbon\Carbon::parse($request->res_checkout_date);
            $nights   = $checkIn->diffInDays($checkOut) ?? 1;
        }

        $results = $this->model::filter($request)
            ->with(['rooms' => function ($query) use ($request) {
                $query->filter($request)->whereHas('reservations', function ($q) use ($request) {
            // Re-use your existing Reservation conflict logic
            $q->filter($request);
        }, '<', DB::raw('rooms_count')); 
        
        // OR the room has no reservations at all for those dates
        $query->orWhereDoesntHave('reservations', function ($q) use ($request) {
            $q->filter($request);
        });;
            }])
            ->paginate(10);

        // Transform the collection inside the cache closure
        $results->getCollection()->transform(function ($hotel) use ($nights) {
            $hotel->rooms->each(function ($room) use ($nights) {
                $room->total_calculated_price = $room->price_per_night * $nights;
            });
            return $hotel;
        });

        return $results;
    }

}
