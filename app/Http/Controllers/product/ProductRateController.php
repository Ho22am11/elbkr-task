<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRateRequest;
use App\Models\ProductRate;
use App\Services\ProductRateService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductRateController extends Controller
{
    use ApiResponseTrait ;
    

    
    public function store(ProductRateRequest $request , ProductRateService $service)
    {
        $result = $service->storeOrUpdate($request->validated());

         return $this->ApiResponse($result['data'] ,$result['message'] , $result['status']);

    }

 
    public function destroy($id)
    {
        ProductRate::destroy($id);
        return $this->ApiResponse(null , 'Rate delted successffly', 201);
    }
}
