<?php
namespace App\Services;

use App\Repositories\HotelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HotelService
{
    protected $hotelRepository;

    public function __construct(HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }

    public function listHotels(Request $request, array $relations = [], array $columns = ['*'])
    {
    
        
        return $this->hotelRepository->list($request, $relations, $columns);
               
    }

    public function createHotel(array $data)
    {

        $hotel = $this->hotelRepository->createHotel($data);

        return $hotel;
    }

    public function findById($id, array $relations = [])
    {
        return $this->hotelRepository->findById($id, $relations);
    }

    public function update($id, array $data)
    {
        $hotel = $this->hotelRepository->update($id, $data);

        return $hotel;
    }

    public function delete($id )
    {
        $hotel = $this->hotelRepository->delete($id);

        return $hotel;
    }

    public function hotelCollection(array $columns = ['*']):Collection
    {
        return $this->hotelRepository->hotelCollection($columns);
    }

    public function search(Request $request)
    {
        $cacheKey = getRequestValuesAsString($request, 'search_hotel');
       return Cache::remember($cacheKey,900, function()use($request){
            return $this->hotelRepository->search($request);
        });

    }

    public function getDashboardCards()
    {

        $stats = Cache::remember("hotels_stats", now()->addHours(1), function () {
            return $this->hotelRepository->getStats();
        });

        return [
            [
                'title'    => 'Total Hotels',
                'value'    => $stats['total_hotels'] ?? 0,
                'color'    => 'primary',
                'svg_path' => 'M3 21h18M3 10h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 10v2m0 4v2m6-6v2m0 4v2', // Building icon
            ],
            [
                'title'    => 'Avg Rating',
                'value'    => $stats['avg_rating'] ?? 0,
                'color'    => 'warning',
                'svg_path' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', // Star icon
            ],
            [
                'title'    => 'Main Market',
                'value'    => $stats['top_country'] ?? 'N/A',
                'color'    => 'success',
                'svg_path' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', // Globe icon
            ],
            [
                'title'    => 'Active Cities',
                'value'    => $stats['total_cities'] ?? 0,
                'color'    => 'info',
                'svg_path' => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z', // City/Layout icon
            ],
            [
                'title'    => 'Active Countries',
                'value'    => $stats['total_countries'] ?? 0,
                'color'    => 'info',
                // New Globe/Map SVG Path
                'svg_path' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253',
            ],
        ];
    }
}
