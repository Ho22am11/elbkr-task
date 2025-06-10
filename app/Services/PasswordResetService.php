<?php
namespace App\Services;

use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class PasswordResetService
{
    public function verifyCode(string $email, string $code): array
    {
        $record = EmailVerification::where('email', $email)->where('code', $code)->first();

        if (!$record) {
            return [
                'error' => 'Invalid verification code or email.',
                'status' => 404,
            ];
        }

        $user = User::where('email', $email)->first();

        $token = JWTAuth::fromUser($user);

        $record->delete();

        return [
            'token' => $token,
        ];
    }


      public function resetPassword(string $newPassword): array
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return [
                'error' => 'User not found.',
                'status' => 404,
            ];
        }

        $user->password = bcrypt($newPassword);
        $user->save();

        return [
            'user' => $user,
        ];
    }


    

}