<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderService
{

    public function getOrders(){
        $user = JWTAuth::parseToken()->authenticate();
        
        $order = Order::with('orderItems.product')
        ->where('user_id', $user->id)
        ->latest()
        ->get();

        return $order ;


    }
    public function store()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return ['error' => 'السلة فارغه'];
        }

        $totalPrice = $cartItems->sum(function ($item) {
            $basePrice = $item->quantity * $item->product->price;
            $statePrices = [1 => 0, 2 => 500, 3 => 850];
            $servicePrice = $statePrices[$item->export_type] ?? 0;
            return $basePrice + $servicePrice;
        });


            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total_price' => $totalPrice,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'export_type' => $cartItem->export_type,
                ]);
            }

            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return $order->load(['orderItems.product']);

            
    }

    
    
    
    public function update($orderId, array $data)
    {
        $order = Order::with('orderItems')->find($orderId);
        
        
        $order->orderItems()->delete();
        
        $createdItems = []; 
        
        foreach ($data['items'] as $item) {
            $createdItem = OrderItem::create([
                'order_id'    => $order->id,
                'product_id'  => $item['product_id'],
                'quantity'    => $item['quantity'],
                'export_type' => $item['export_type'],
            ]);
            $createdItems[] = $createdItem;
        }
        
        collect($createdItems)->each->load('product');
        
        $totalPrice = collect($createdItems)->sum(function ($item) {
            $basePrice = $item->quantity * $item->product->price;
            $statePrices = [1 => 0, 2 => 500, 3 => 850];
            $servicePrice = $statePrices[$item->export_type] ?? 0;
            return $basePrice + $servicePrice;
        });
        
        $order->update([
            'total_price' => $totalPrice
        ]);
        
        return ['order' => $order->load('orderItems.product')];
    }
    
    public function cancelOrder($id){
        $user = JWTAuth::parseToken()->authenticate();
        
        $order = Order::where('id', $id)
        ->where('user_id', $user->id)
        ->first();
        
        
        
        $order->status = 'cancelled';
        $order->save();
        
        return $order ;
        
        
    }
    
}