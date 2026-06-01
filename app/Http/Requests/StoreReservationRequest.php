<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'customer_name' => 'required|string|min:2|max:120',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}