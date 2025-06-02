<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\PasswordResetController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\product\CampanyController;
use App\Http\Controllers\product\CategoryController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\product\ProductRateController;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);

Route::prefix('auth')->group(function(){
    Route::post('/register' , [ AuthController::class , 'register']);
    Route::post('login' , [ AuthController::class , 'login']);
    Route::post('logout' , [ AuthController::class , 'logout']);
    Route::post('refresh' , [ AuthController::class , 'refresh']);
});

Route::post('/send-reset-code', [PasswordResetController::class, 'sendPasswordResetCode']);
Route::post('/verify-reset-code', [PasswordResetController::class, 'verifyResetCode']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

Route::resource('/categories' , CategoryController::class);

Route::resource('/campanies' , CampanyController::class);
Route::post('/campanies/{id}', [CampanyController::class, 'update']);

Route::resource('/products', ProductController::class);
Route::post('/products/{id}', [ProductController::class, 'update']);
Route::resource('/rates', ProductRateController::class);


