<?php
namespace App\Services;

use App\Models\Admin;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Auth;

class authAdminService
{
    public function register(array $data)
    {

        $user = Admin::create([
            'frist_name' => $data['frist_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => bcrypt($data['password']),
        ]);

        $token = auth()->guard('admin')->attempt([
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);


        if (!$token) {
            return ['error' => 'Unauthorized', 'status' => 401];
        }

        $user->token = $token;



        return ['user' => $user];
    }

     public function login(array $data)
    {
        $credentials = ['email' => $data['email'],'password' => $data['password']];
        $token = auth()->guard('admin')->attempt($credentials);

        if (!$token) {
            return [
                'error' => 'Unauthorized. Invalid credentials.',
                'status' => 401,
            ];
        }

        $user = Auth::guard('admin')->user();
        $user->token = $token;

        return $user ;
    }
}
