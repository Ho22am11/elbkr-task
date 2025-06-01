<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);

Route::prefix('auth')->group(function(){
    Route::post('/register' , [ AuthController::class , 'register']);
    Route::post('login' , [ AuthController::class , 'login']);
    Route::post('logout' , [ AuthController::class , 'logout']);
    Route::post('refresh' , [ AuthController::class , 'refresh']);
});


