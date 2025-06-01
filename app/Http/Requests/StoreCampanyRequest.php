<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCampanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'img'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    
   public function messages()
    {
        
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصاً',
            'name.max' => 'الاسم لا يجب أن يزيد عن 255 حرفاً',

            'img.required' => 'الصوره مطلوب',
            'img.image' => 'يجب أن يكون الملف صورة',
            'img.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif, svg',
            'img.max' => 'الصورة لا يجب أن تتجاوز 2 ميغابايت',
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
