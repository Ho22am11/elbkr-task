<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    use ApiResponseTrait ;
    public function index()
    {
        $order = Order::with('orderItems.product')->latest()->get();
         return $this->ApiResponse( OrderResource::collection($order) , 'orders retrieved successfully', 200);
        
    }
    public function destroy($id)
    {
        Order::destroy($id);
        return $this->ApiResponse(null , 'Order deleted successffly', 201);
    }
}
