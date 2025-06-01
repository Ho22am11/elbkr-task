<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\EmailVerificationService;
use App\Http\Requests\SendVerificationCodeRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Models\EmailVerification;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait ;
    public function sendVerificationCode(SendVerificationCodeRequest $request , EmailVerificationService $service)
    {
        
        $service->sendCode($request->email);
        
        return $this->ApiResponse( null , 'Verification code sent successfully.' , 200);
    }
    

    
    public function verifyCode(VerifyCodeRequest $request , EmailVerificationService $service )
    {
        $verifyCode =$service->verifyCode($request->email , $request->code);

        if (!$verifyCode) {
            return $this->ApiResponse( null , 'Invalid verification code.' , 422);
        }
        
        return response()->json(['message' => 'Email verified successfully.']);
        return $this->ApiResponse( null , 'Email verified successfully.' , 200);
        
    }
    
    
        
    

}
