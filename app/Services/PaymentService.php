<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentService
{

     protected $stripe ;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_key.secret'));
    }

     public function pay(Request $request){

        $order = Order::find( $request->order_id);

        $session = $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => "Order ",
                    ],
                    'unit_amount' => $order->total_price,
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',

        ]);
        return response()->json([
                'url' => $session->url  ]);


    }


}
