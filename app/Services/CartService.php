<?php

namespace App\Services;

use App\Models\CartItem;
use App\Http\Resources\CartResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartService
{
       public function getcart()
    {
       $user = JWTAuth::parseToken()->authenticate();
    $items = CartItem::with('product')->where('user_id', $user->id)->get();
    
    $total = $items->sum(function ($item) {
        $basePrice = $item->quantity * $item->product->price;
        $statePrices = [1 => 0, 2 => 500, 3 => 850];
        $servicePrice = $statePrices[$item->export_type] ?? 0;
        return $basePrice + $servicePrice;
    });

    return ['items' => $items , 'total' => $total];
    }



}