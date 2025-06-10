<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\EmailVerificationService;
use App\Http\Requests\SendVerificationCodeRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Models\EmailVerification;
use App\Models\User;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        
        return $this->ApiResponse( null , 'Email verified successfully.' , 200);
        
    }
    
    public function register(RegisterRequest $request , AuthService $authService)
    {
    
         $user = $authService->register($request->all());

        if (isset($user['error'])) {
            return $this->ApiResponse( null , $user['error']  , $user['status']);

        }

        return $this->ApiResponse( $user , 'Registration successful.' , 201);
        
    }


    public function login(LoginRequest $request , AuthService $authService)
    {

        $user = $authService->login($request->all());

        if (isset($user['error'])) {
            return $this->ApiResponse( null , $user['error']  , $user['status']);

        }
        return $this->ApiResponse( $user , 'login successfully' , 201);

    }


    public function logout(Request $request){
        $token = $request->bearerToken();

        JWTAuth::setToken($token)->invalidate();

        return $this->ApiResponse( null , 'Logged out successfully' , 201);
    
    }

    public function refresh(Request $request){

        $token = $request->bearerToken();
        
        JWTAuth::setToken($token)->refresh();

        return $this->ApiResponse( $token , 'refresh successfully' , 201);
    }
    


}
