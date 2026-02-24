<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'customer_whatsapp' => 'required|string|max:20',
            'travel_date' => 'required|date|after_or_equal:today',
            'qty' => 'required|integer|min:1',
            'trip_id' => 'required|string',
            'use_drone' => 'nullable|boolean',
            'hotel_1' => 'nullable|string|max:255',
            'hotel_2' => 'nullable|string|max:255',
            'hotel_3' => 'nullable|string|max:255',
            'hotel_4' => 'nullable|string|max:255',
            'tiba' => 'nullable|date',
            'flight_balik' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'hp_field' => 'nullable|string|size:0', // Honeypot should be empty
        ];
    }
}
