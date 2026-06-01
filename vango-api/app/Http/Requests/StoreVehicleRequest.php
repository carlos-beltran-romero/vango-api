<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'slug' => 'required|string|max:120|unique:vehicles,slug',
            'name' => 'required|string|max:120',
            'brand' => 'required|string|max:80',
            'price_per_day' => 'required|numeric|min:1|max:9999',
            'description' => 'required|string|max:2000',
            'images' => 'nullable|array',
            'images.*' => 'required_with:images|url',
            'features' => 'nullable|array',
            'features.*' => 'required_with:features|string|max:80',
            'capacity' => 'required|integer|min:1|max:10',
            'transmission' => 'required|string|in:Manual,Automática',
            'fuel' => 'required|string|max:50',
            'is_active' => 'sometimes|boolean',
        ];
    }
}