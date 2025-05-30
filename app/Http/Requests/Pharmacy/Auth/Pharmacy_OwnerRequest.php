<?php

namespace App\Http\Requests\Pharmacy\Auth;

use Illuminate\Foundation\Http\FormRequest;

class Pharmacy_OwnerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'pharmacy_name' => 'required|string|max:255',
            'pharmacy_phone' => 'required|string|max:20',
            'pharmacy_address' => 'required|string|max:255',
        ];
    }

}
