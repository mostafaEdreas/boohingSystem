<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchAvailabilityRequest;
use App\Http\Resources\HotelResource;
use App\Services\HotelService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        protected HotelService $hotelService
    ) {}

    /**
     * Search availability by city, dates, guests.
     * GET /api/search
     * Response: hotel details, available rooms, total price (price × nights) per room.
     */
    public function search(SearchAvailabilityRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $validated = $request->validated();
        $mapped = new Request([
            'h_city' => $validated['city'] ?? null,
            'res_checkin_date' => $validated['checkin_date'] ?? null,
            'res_checkout_date' => $validated['checkout_date'] ?? null,
            'r_guests' => $validated['guests'] ?? null,
        ]);

        $results = $this->hotelService->search($mapped);

        return HotelResource::collection($results);
    }
}
