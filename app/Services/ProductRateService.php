<?php

namespace App\Services;

use App\Models\ProductRate;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductRateService
{
    public function storeOrUpdate(array $data)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return [
                'status'  => 403,
                'message' => 'Unauthorized',
                'data'    => null,
            ];
        }

        $rate = ProductRate::where('product_id', $data['product_id'])
                           ->where('user_id', $user->id)
                           ->first();

        if ($rate) {
            $rate->update($data);
            return [
                'status'  => 200,
                'message' => 'Rate updated successffly',
                'data'    => $rate,
            ];
        }

        $data['user_id'] = $user->id;

        $newRate = ProductRate::create($data);

        return [
            'status'  => 201,
            'message' => 'Rate Stored successffly' ,
            'data'    => $newRate,
        ];
    }
}
