<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdjustStockRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'batch_id' => 'required|exists:batches,id',
            'type' => 'required|in:IN,OUT',
            'qty' => 'required|integer|min:1',
        ];
    }
}
