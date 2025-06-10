<?php
namespace App\Services;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        $verification = EmailVerification::where('email', $data['email'])->where('verified', true)->first();

        if (!$verification) {
            return ['error' => 'Please verify your email first.', 'status' => 403];
        }

        $user = User::create([
            'frist_name' => $data['frist_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => bcrypt($data['password']),
        ]);

        $token = auth()->guard('user')->attempt([
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        if (!$token) {
            return ['error' => 'Unauthorized', 'status' => 401];
        }

        $verification->delete();

        $user->token = $token;

        return ['user' => $user];
    }

    public function login(array $data)
    {
        $credentials = ['email' => $data['email'],'password' => $data['password']];
        $token = auth()->guard('user')->attempt($credentials);

        if (!$token) {
            return [
                'error' => 'Unauthorized. Invalid credentials.',
                'status' => 401,
            ];
        }

        $user = Auth::guard('user')->user();
        $user->token = $token;

        return $user ;
    }
}
