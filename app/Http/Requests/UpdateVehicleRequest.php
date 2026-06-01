<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        $vehicleId = $this->route('vehicle')?->id;

        return [
            'slug' => [
                'sometimes',
                'string',
                'max:120',
                Rule::unique('vehicles', 'slug')->ignore($vehicleId),
            ],
            'name' => 'sometimes|string|max:120',
            'brand' => 'sometimes|string|max:80',
            'price_per_day' => 'sometimes|numeric|min:1|max:9999',
            'description' => 'sometimes|string|max:2000',
            'images' => 'nullable|array',
            'images.*' => 'required_with:images|url',
            'features' => 'nullable|array',
            'features.*' => 'required_with:features|string|max:80',
            'capacity' => 'sometimes|integer|min:1|max:10',
            'transmission' => 'sometimes|string|in:Manual,Automática',
            'fuel' => 'sometimes|string|max:50',
            'is_active' => 'sometimes|boolean',
        ];
    }
}