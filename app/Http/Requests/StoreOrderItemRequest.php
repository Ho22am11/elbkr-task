<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'export_type' => 'required|in:1,2,3', 
        ];
    }

     public function messages(): array
    {
        return [


            'product_id.required' => 'حقل المنتج مطلوب.',
            'product_id.exists' => 'المنتج المحدد غير موجود.',

            'quantity.required' => 'حقل الكمية مطلوب.',
            'quantity.integer' => 'يجب أن تكون الكمية عددًا صحيحًا.',
            'quantity.min' => 'يجب أن تكون الكمية على الأقل 1.',

            'export_type.required' => 'نوع التصدير مطلوب.',
            'export_type.in' => 'نوع التصدير يجب أن يكون أحد القيم التالية: 1 أو 2 أو 3.',
        ];
    }




     protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
