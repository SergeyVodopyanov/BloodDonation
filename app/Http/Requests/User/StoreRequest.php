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
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'userLastName' => 'required|string',
            'userFirstName' => 'required|string',
            'userMiddleName' => 'nullable|string',
            'userPassportSeries' => 'required|string|unique:users',
            'userPassportNumber' => 'required|string|unique:users',
            'cityId' => 'required|integer',
            'bloodGroupId' => 'required|integer',
        ];
    }
}