<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OfferRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:20',
            'project_type'      => 'required',
            'message'      => 'required',

        ];
    }


    public function messages(): array
    {
        return [
            'frist_name.required' => 'Please provide your first name.',
            'last_name.required'  => 'Please provide your last name.',
            'email.required'      => 'Email is required.',
            'email.email'         => 'The email format is invalid.',
            'email.unique'        => 'This email is already registered.',
            'phone.required'      => 'Phone number is required.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 6 characters.',
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
