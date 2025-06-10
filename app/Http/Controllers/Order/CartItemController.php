<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Resources\cartItemResource;
use App\Http\Resources\cartResource;
use App\Models\CartItem;
use App\Services\CartService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartItemController extends Controller
{
    use ApiResponseTrait ;

    public function index( CartService $cartservice)
{
    $cart = $cartservice->getcart();

    return $this->ApiResponse(['items' => CartResource::collection($cart['items']),
        'total_price' => $cart['total']]
        , 'cart retrieved successflly' , 200) ;
        
}

     public function store(StoreOrderItemRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

            $data = $request->all();
            $data['user_id'] = $user->id;
            $cart = CartItem::create($data);
        return $this->ApiResponse(new cartItemResource($cart) , 'cart stored successflly' , 201) ;
    }

    public function update(StoreOrderItemRequest $request ,$id )
    {

        $cart = CartItem::find($id);
        $cart->update($request->all());
        return $this->ApiResponse(new cartItemResource($cart), 'cart updated successflly' , 200) ;
    }


     public function destroy($id)
    {
        CartItem::destroy($id);
        return $this->ApiResponse(null , 'cart item delted successffly', 201);
    }


         
}
