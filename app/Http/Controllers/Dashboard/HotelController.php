<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Services\HotelService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected HotelService $hotelService;
    public function __construct(HotelService $hotelService)
     {
        $this->hotelService = $hotelService;
         $this->middleware('auth');
     }
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data['hotels'] = $this->hotelService->listHotels($request);
        return view('hotels.index', $data);
    }

    public function create()
    {
        return view('hotels.create');
    }


    public function store(HotelRequest $request)
    {
        $data = $request->validated();

        $hotel = $this->hotelService->createHotel($data);

        if ($hotel) {
            return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create hotel. Please try again.');
        }

    }


    public  function edit($id)
    {
       $data['hotel'] = $this->hotelService->findById($id);

       return view('hotels.edit' ,$data);


    }


    public function update($id, HotelRequest $request) 
    {
        $this->hotelService->update($id,$request->validated())   ;
        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel updated successfully.'); 
    }


    public function destroy($id)
    {
        $this->hotelService->delete($id);
        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel deleted successfully.'); 
    }


}
