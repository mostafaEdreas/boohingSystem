<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Set to true to allow the request to proceed.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules matching your Trait and Repository logic.
     */
    public function rules(): array
    {
        return [
            // Hotel Filters
            'h_city' => 'nullable|string|max:100',

            'r_guests' => 'nullable|integer|min:1', // Alias for occupancy if needed

            // Reservation/Availability Dates
            'res_checkin_date' => 'required_with:res_checkout_date|date|after_or_equal:today',
            'res_checkout_date' => 'required_with:res_checkin_date|date|after_or_equal:res_checkin_date',
        ];
    }

    public function attributes(): array
    {
        return [
            'h_city' => 'City Name',
            'res_checkin_date' => 'Check-in Date',
            'r_guests' => 'Number of Guests',
            'res_checkout_date' => 'Check-out Date',
        ];
    }
}
