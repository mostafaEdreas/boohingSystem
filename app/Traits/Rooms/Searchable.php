<?php

namespace App\Traits\Rooms;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Searchable
{
    public function scopeFilter(Builder $query , Request $request): Builder
    {
        // 1. Get all request data 
        $filters = $request->only(config('filter.room'));

        foreach ($filters as $key => $value) {
            // 2. Skip empty values to avoid filtering by null
            if (is_null($value) || $value === '') continue;

            // 3. Check if a function exists with the SAME name as the request key
            if (method_exists($this, $key)) {
                // 4. Run it: Pass the query and the value
                $this->$key($query, $value);
            }
        }


        return $query;
    }

    // Filter by max occupancy
    protected function r_guests(Builder $query, $value)
    {
        return $query->where('max_occupancy', '>=', $value);
    }

    protected function r_available_rooms(Builder $query, $value)
    {
        return $query->where('available_rooms', '>',  0);
    }




    protected function r_hotel(Builder $query, $value)
    {
        return $query->where('hotel_id', $value);
    }
    
}