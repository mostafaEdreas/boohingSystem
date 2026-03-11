<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $roomService
    ) {}

    /**
     * Create room.
     * POST /api/rooms
     */
    public function store(RoomRequest $request): JsonResponse
    {
        $room = $this->roomService->createNewRoom($request->validated());

        return (new RoomResource($room))
            ->additional(['message' => 'Room created successfully.'])
            ->response()
            ->setStatusCode(201);
    }
}
