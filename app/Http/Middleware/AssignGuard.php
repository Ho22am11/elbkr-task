<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class AssignGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $guard)
    {
        if (Auth::guard($guard)->check()) {
            return $next($request); 
        }

    return response()->json([
        'error' => 'Forbidden',
        'massege' => 'You are not an '.$guard
    ], 403);
    }
       
    
}
