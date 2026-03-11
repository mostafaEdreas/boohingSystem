<?php

namespace App\Traits\Hotels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Searchable
{

   

    public function scopeFilter(Builder $query  , Request $request): Builder
    {
      
        $hotelFilters = $request->only(config('filter.hotel')); 
        foreach ($hotelFilters as $key => $value) {
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

    // Filter by City
    protected function h_city(Builder $query, $value)
    {
        return $query->where('city', 'like', "%$value%"); 
    }



    protected function h_rating ($query,$value){
        return $query->where('rating',  $value);
    }

    protected function h_country ($query,$value){
        return $query->where('country', 'like', "%$value%");
    }

       
}