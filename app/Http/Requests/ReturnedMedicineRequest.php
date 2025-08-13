<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnedMedicineRequest extends FormRequest
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
            // 'items' => 'required|array|min:1',
            'medicine_id' => 'required|exists:medicines,id',//unique:Pharmacy_Stocks,medicine_id
            'quantity' => 'required|integer|min:1',
            'batch' => 'required|string',
            'Purchase_price' => 'required|min:1',
            'sale_price' => 'required|min:1',
            'expiration_date' => 'required|date',
        ];
    }
}
