<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\EmailVerificationService;
use App\Http\Requests\SendVerificationCodeRequest;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait ;
    public function sendVerificationCode(SendVerificationCodeRequest $request , EmailVerificationService $service)
{
    
    $service->sendCode($request->email);

    return $this->ApiResponse( null , 'Verification code sent successfully.' , 200);
}

}
