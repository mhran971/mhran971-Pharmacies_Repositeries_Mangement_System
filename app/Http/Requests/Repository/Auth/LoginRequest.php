<?php

namespace App\Http\Requests\Repository\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //'name' => 'required|string|max:255',
            //  'phone_number' => 'required|numeric|digits:10|unique:users,phone_number',
            'email' => 'required|email|',
            'password' => 'required|string|min:8|confirmed',
//            'repository_id' => 'required|exists:repositories,id',
        ];
    }

}
