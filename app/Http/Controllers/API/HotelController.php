<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use App\Services\HotelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        protected HotelService $hotelService
    ) {}

    /**
     * List hotels with filters (city, rating) and pagination.
     * GET /api/hotels
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $request->merge([
            'h_city' => $request->input('city'),
            'h_rating' => $request->input('rating'),
        ]);

        $hotels = $this->hotelService->listHotels($request);

        return HotelResource::collection($hotels);
    }

    /**
     * Create hotel.
     * POST /api/hotels
     */
    public function store(HotelRequest $request): JsonResponse
    {
        d
        $hotel = $this->hotelService->createHotel($request->validated());

        return (new HotelResource($hotel))
            ->additional(['message' => 'Hotel created successfully.'])
            ->response()
            ->setStatusCode(201);
    }
}
