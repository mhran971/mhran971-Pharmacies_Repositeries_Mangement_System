<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkSalesMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.batch' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'معرف المستخدم مطلوب.',
            'user_id.exists' => 'المستخدم غير موجود.',
            'pharmacy_id.required' => 'معرف الصيدلية مطلوب.',
            'pharmacy_id.exists' => 'الصيدلية غير موجودة.',
            'items.required' => 'قائمة الأدوية مطلوبة.',
            'items.*.medicine_id.required' => 'معرف الدواء مطلوب.',
            'items.*.medicine_id.exists' => 'الدواء غير موجود.',
            'items.*.quantity.required' => 'الكمية مطلوبة.',
            'items.*.quantity.integer' => 'الكمية يجب أن تكون رقمًا صحيحًا.',
            'items.*.batch.required' => 'رقم الدفعة مطلوب.',
        ];
    }
}
