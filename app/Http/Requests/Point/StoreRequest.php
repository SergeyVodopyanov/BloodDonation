<?php

namespace App\Http\Requests\Point;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'nullable|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'geolocation' => 'required|string',
            'first_blood_group_count' => 'required|integer',
            'second_blood_group_count' => 'required|integer',
            'third_blood_group_count' => 'required|integer',
            'fourth_blood_group_count' => 'required|integer',
            'enough_count' => 'nullable|integer',
        ];
    }
}
