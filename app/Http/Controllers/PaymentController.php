<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{


     public function pay(Request $request,PaymentService $paymentService ){

        $paymentLink = $paymentService->pay($request);

        return $paymentLink;


    }
}
