<?php

namespace App\Observers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Cache;

class HotelObserver
{
    /**
     * Handle events that should clear/version the search cache.
     */
    private function clearSearchCache()
    {
        // This is the "Magic Button"
        // Every search query will now look for 'hotels_v2' instead of 'hotels_v1'
        Cache::increment('search_hotel');
    }

    private function clearStatCache()
    {
        
        Cache::forget('hotels_stats');
    }

    public function created(Hotel $hotel) 
    {
        $this->clearSearchCache();
        $this->clearStatCache();
    }

    public function updated(Hotel $hotel) 
     {
        $this->clearSearchCache();
        $this->clearStatCache();
    }

    public function deleted(Hotel $hotel) 
     {
        $this->clearSearchCache();
        $this->clearStatCache();
    }

    public function restored(Hotel $hotel)
     {
        $this->clearSearchCache();
        $this->clearStatCache();
    }
}