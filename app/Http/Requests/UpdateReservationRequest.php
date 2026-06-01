<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'start_date' => 'sometimes|date|after_or_equal:today',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'status' => 'sometimes|string|in:pending,confirmed,cancelled',
            'customer_name' => 'sometimes|string|min:2|max:120',
            'customer_email' => 'sometimes|email|max:255',
            'customer_phone' => 'sometimes|string|max:30',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}