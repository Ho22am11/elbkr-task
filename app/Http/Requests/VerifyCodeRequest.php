<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;  
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'code'  => 'required|digits:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email'    => 'Please enter a valid email.',
            'code.required'  => 'Verification code is required.',
            'code.digits'    => 'Verification code must be exactly 6 digits.',
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
