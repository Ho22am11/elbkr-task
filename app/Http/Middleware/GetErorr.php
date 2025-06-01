<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class GetErorr
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        try {
            // تمرير الطلب إلى الجزء التالي
            return $next($request);
        } catch (\Exception $e) {
            // تسجيل الخطأ في السجل
            
            // إعادة استجابة خطأ
            return response()->json([
                'status' => 400,
                'error' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 500);
        }
            

    }
}
