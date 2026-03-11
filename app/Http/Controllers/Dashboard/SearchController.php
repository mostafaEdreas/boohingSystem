<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Services\HotelService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct( protected HotelService $hotelService)
    {
       
    }
    public function search(SearchRequest $request){
        $filledRequest = new Request($request->validated());

        $data['results'] = $this->hotelService->search($filledRequest);
        return view('search.index' ,$data);
    }
}
