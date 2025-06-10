<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetCodeRequest;
use App\Http\Requests\VerifyResetCodeRequest;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use App\Services\EmailVerificationService;
use App\Services\PasswordResetService;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class PasswordResetController extends Controller
{
    use ApiResponseTrait;
    public function sendPasswordResetCode(SendResetCodeRequest $request , EmailVerificationService $reset)
    {
        $reset->sendCode($request->email);
         return $this->ApiResponse( null , 'Password reset code sent.' , 200);
    }


    public function verifyResetCode(VerifyResetCodeRequest $request , PasswordResetService $reset)
    { 
        $result = $reset->verifyCode($request->email, $request->code);
        
        if (isset($result['error'])) {
            return $this->ApiResponse(null, $result['error'], $result['status']);
        }
        
        return $this->ApiResponse(['token' => $result['token']], 'Email verified successfully.', 200);
        
    }


    public function resetPassword(ResetPasswordRequest $request , PasswordResetService $reset )
    {
        $user = $reset->resetPassword($request->password) ;
        return $this->ApiResponse($user , 'Password has been reset successfully.', 200);
    }
        
    

}
