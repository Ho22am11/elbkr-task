<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiBaseRequest extends FormRequest
{
   protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => 422,
                'message' => 'فشل التحقق من البيانات.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
