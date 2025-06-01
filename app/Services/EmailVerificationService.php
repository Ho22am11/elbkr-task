<?php

namespace App\Services;

use App\Mail\VerificationCodeMail;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;


class EmailVerificationService
{
    public function sendCode(string $email): void
    {
        $code = rand(100000, 999999);

        EmailVerification::where('email', $email)->delete();
        EmailVerification::create([
            'email' => $email,
            'code' => $code,
        ]);

        Mail::to($email)->send(new VerificationCodeMail($code));
    }



    public function verifyCode(string $email, string $code): bool
    {
        $record = EmailVerification::where('email', $email)
                    ->where('code', $code)
                    ->first();

        if (!$record) {
            return false;
        }

        $record->update(['verified' => true]);
        

        return true;
    }



}