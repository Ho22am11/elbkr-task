<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{


    public function handle($request, Closure $next)
    {
        if (!auth('admin')->check()) {
            return response()->json(['error' => 'Unauthorized you not are admin'], 401);
        }

        return $next($request);
    }

}
