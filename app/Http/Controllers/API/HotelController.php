<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Requests\RoomRequest; // You'll need to create this
use App\Http\Resources\HotelResource;
use App\Http\Resources\RoomResource;
use App\Services\HotelService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelApiController extends Controller
{
    protected HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        // For APIs, it's often better to apply auth in the route file
        $this->hotelService = $hotelService;
    }

    /**
     * 2- List Hotels (with filtering & pagination)
     * GET /api/hotels
     */
    public function index(Request $request)
    {
        $hotels = $this->hotelService->listHotels($request);
        return HotelResource::collection($hotels);
    }

    /**
     * 1- Create Hotel
     * POST /api/hotels
     */
    public function store(HotelRequest $request): JsonResponse
    {
        $hotel = $this->hotelService->createHotel($request->validated());

        return (new HotelResource($hotel))
            ->additional(['message' => 'Hotel created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * 3- Create Room
     * POST /api/rooms
     */
    public function storeRoom(RoomRequest $request): JsonResponse
    {
        $room = $this->hotelService->createRoom($request->validated());
        return (new RoomResource($room))
            ->additional(['message' => 'Room created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * 4- Search Availability
     * GET /api/search
     */
    public function search(Request $request)
    {
        $results = $this->hotelService->searchAvailability(
            $request->only(['city', 'checkin_date', 'checkout_date', 'guests'])
        );

        return HotelResource::collection($results);
    }
}