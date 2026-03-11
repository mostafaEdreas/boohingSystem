<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Services\HotelService;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    
    protected $roomService;
    protected $hotelService;

    // Inject the Service into the constructor
    public function __construct(RoomService $roomService ,HotelService $hotelService)
    {
        $this->roomService = $roomService;
        $this->hotelService = $hotelService ;
    }

    

    public function index(Request $request )
    {
        $columns = ['id','name','available_rooms', 'max_occupancy', 'rooms_count','hotel_id','price_per_night'];
        $hotelColums =  ['id','name'] ;
        $data['hotels'] = $this->hotelService->hotelCollection( $hotelColums);
        $data['rooms'] = $this->roomService->listRooms($request, true , $columns);
        return view('rooms.index', $data);
    }

    public function store(RoomRequest $request)
    {
        
        $room = $this->roomService->createNewRoom($request->validated());

        return redirect()->route('dashboard.rooms.index')->with('success','Room created successfully');
    }

    public function create()
    {
        $columns = ['id' ,'name'] ;
        $data['hotels'] = $this->hotelService->hotelCollection( $columns);
        return view('rooms.create', $data);
    }

}
