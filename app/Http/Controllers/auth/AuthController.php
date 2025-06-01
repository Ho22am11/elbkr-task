<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\EmailVerificationService;
use App\Http\Requests\SendVerificationCodeRequest;



class AuthController extends Controller
{
    public function sendVerificationCode(SendVerificationCodeRequest $request , EmailVerificationService $service)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
    ]);

    $service->sendCode($request->email);

    return response()->json(['message' => 'Verification code sent.']);
}

}
