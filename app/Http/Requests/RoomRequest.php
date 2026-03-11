<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_id'        => 'required|exists:hotels,id',
            'name'            => 'required|string|max:255|unique:rooms,name,'.$this->route('room'),
            'price_per_night' => 'required|numeric|min:0|max:99999999.99',
            'max_occupancy'   => 'required|integer|min:1|max:20',
            'available_rooms' => 'required|integer|min:0',
            'rooms_count'     => 'required|integer|min:1',

        ];
    }
}
