<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\HotelService;
use App\Services\RoomService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $hotelService;
    protected $roomService;

    public function __construct(HotelService $hotelService, RoomService $roomService)
    {
        $this->hotelService = $hotelService;
        $this->roomService = $roomService;
    }

    public function index()
    {
        // 1. Get Hotel specific cards (Hotels, Countries, Avg Rating)
        $hotelCards = $this->hotelService->getDashboardCards();

        // 2. Get Room specific cards (Total Rooms, Available, Occupancy)
        $roomCards = $this->roomService->getRoomDashboardCards();

        // 3. Merge them into one dashboard array
        $allCards = array_merge($hotelCards, $roomCards);

        return view('dashboard', ['allCards' => $allCards]);
    }
}