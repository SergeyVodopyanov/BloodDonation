<?php

namespace App\Http\Requests\User;

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
            'image' => 'nullable|file',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'passport_series' => 'required|integer',
            'passport_number' => 'required|integer',
            'city' => 'required|string',
            'blood_group' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Поле email должно быть действительным email адресом.',
            'password.required' => 'Поле пароль обязательно для заполнения.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password_confirmation.required' => 'Поле подтверждение пароля обязательно для заполнения.',
            'last_name.required' => 'Поле фамилия обязательно для заполнения.',
            'first_name.required' => 'Поле имя обязательно для заполнения.',
            'passport_series.required' => 'Поле серия паспорта обязательно для заполнения.',
            'passport_series.unique' => 'Серия паспорта уже используется.',
            'passport_number.required' => 'Поле номер паспорта обязательно для заполнения.',
            'passport_number.unique' => 'Номер паспорта уже используется.',
            'city.required' => 'Поле город обязательно для заполнения.',
            'blood_group.required' => 'Поле группа крови обязательно для заполнения.',
        ];
    }
}
