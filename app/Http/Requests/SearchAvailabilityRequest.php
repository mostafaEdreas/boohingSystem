<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city' => 'nullable|string|max:255',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after_or_equal:checkin_date',
            'guests' => 'required|integer|min:1',
        ];
    }
}
