<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendVerificationCodeRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Please provide your email address.',
            'email.email'    => 'The email format is invalid.',
            'email.unique'   => 'This email is already registered.',
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
