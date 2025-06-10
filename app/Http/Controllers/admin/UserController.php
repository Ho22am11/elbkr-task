<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait ;
    public function deleteAccount($id)
    {
        User::destroy($id);
        return $this->ApiResponse(null , 'Order deleted successffly', 201);
    }
}
