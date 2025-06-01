<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $cate = category::all();
        return $this->ApiResponse($cate , 'Categories retrieved successfully' , 200);
    }


}
