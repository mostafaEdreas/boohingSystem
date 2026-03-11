<?php

namespace App\Traits\Reservations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Searchable
{
    public function scopeFilter(Builder $query , Request $request): Builder
    {
        // 1. Get all request data 
        $filters = $request->only(config('filter.reservation'));
        unset($filters['res_checkin_date'], $filters['res_checkout_date']);
       
        foreach ($filters as $key => $value) {
            // 2. Skip empty values to avoid filtering by null
            if (is_null($value) || $value === '') continue;

            // 3. Check if a function exists with the SAME name as the request key
            if (method_exists($this, $key)) {
                // 4. Run it: Pass the query and the value
                $this->$key($query, $value);
            }
        }

        if ($request->has('res_checkin_date') && $request->has('res_checkout_date')) {
             $slots = $request->only(['res_checkin_date', 'res_checkout_date']);
            $this->conflicts($query,  $slots);
        }
        return $query;
    }

    protected function conflicts(Builder $query, array $slots)
    {
        return $query->where('checkin_date', '<', $slots['res_checkout_date'])
                     ->where('checkout_date', '>', $slots['res_checkin_date']);
    }

    
}