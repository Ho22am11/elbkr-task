<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Services\authAdminService;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthAdminController extends Controller
{
        use ApiResponseTrait ;

    public function register(RegisterAdminRequest $request , authAdminService $authadminservice)
    {

         $user = $authadminservice->register($request->all());

        if (isset($user['error'])) {
            return $this->ApiResponse( null , $user['error']  , $user['status']);

        }

        return $this->ApiResponse( $user , 'Registration successful.' , 201);
    }

     public function login(Request $request , authAdminService $authadminservice)
    {

        $user = $authadminservice->login($request->all());

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
}
