<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    use ApiResponseTrait ;

     protected $orderservice;

    public function __construct(OrderService $orderservice)
    {
        $this->orderservice = $orderservice;
    }


    public function index()
    {
        $order =$this->orderservice->getOrders();
         return $this->ApiResponse( OrderResource::collection($order) , 'order retrieved successfully', 200);
        
    }




    public function store(Request $request)
    {
        $order =$this->orderservice->store();

         if (isset($result['error'])) {
        return response()->json(['message' => $result['error']], 400);
        }

        return $this->ApiResponse(new OrderResource($order) , 'order stored successflly' , 201) ;

    }


    public function show($id)
    {
        $order = Order::find($id);
        return $this->ApiResponse(new OrderResource($order->load(['orderItems.product'])) , 'order retrieved successflly' , 200) ;
    }


    public function update(Request $request, $id)
    {

        $result = $this->orderservice->update($id, $request->all());

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], 400);
        }
        
        return $this->ApiResponse(new OrderResource($result['order']), 'order retrieved successfully', 200);
        
        
    }


    public function cancelOrder($id)
    {
        $order =$this->orderservice->cancelOrder($id);        
        
        return $this->ApiResponse(new OrderResource($order), 'Order cancelled successfully', 200);
    }
    
}
