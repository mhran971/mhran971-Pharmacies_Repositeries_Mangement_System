<?php

namespace App\Http\Requests\Repository\Authorization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Assign_PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        if ($user && $user->owner()->exists()) {
            return true;
        }
        else{
            return false;
        }    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permissions'=>'array|int',
            'role'=>'string|max:20|min:3'
        ];
    }
}
