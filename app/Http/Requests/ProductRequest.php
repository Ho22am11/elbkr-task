<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric',
            'campany_id'   => 'required|exists:campanies,id',
            'category_id'  => 'required|exists:categories,id',
            'img.*'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'اسم المنتج مطلوب',
            'price.required'       => 'سعر المنتج مطلوب',
            'description.required'       => 'وصف المنتج مطلوب',
            'campany_id.required'  => 'الشركة مطلوبة',
            'category_id.required' => 'القسم مطلوب',
            'img.*.image'          => 'يجب أن يكون كل ملف من نوع صورة',
            'img.*.mimes'          => 'الصور يجب أن تكون بصيغة jpeg, png, jpg, gif أو svg',
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
