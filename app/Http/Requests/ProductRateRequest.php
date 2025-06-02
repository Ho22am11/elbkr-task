<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|numeric|min:1|max:5',
            'content'    => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'يجب اختيار المنتج.',
            'product_id.exists'   => 'المنتج غير موجود.',
            'rating.required'     => 'التقييم مطلوب.',
            'rating.numeric'      => 'يجب أن يكون التقييم رقمًا.',
            'rating.min'          => 'أقل تقييم هو 1.',
            'rating.max'          => 'أعلى تقييم هو 5.',
            'content.string'      => 'المحتوى يجب أن يكون نصًا.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
