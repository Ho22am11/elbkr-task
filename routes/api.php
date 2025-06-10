<?php

use App\Http\Controllers\admin\OrderAdminController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\PasswordResetController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Order\CartItemController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\admin\AuthAdminController;
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

Route::post('/send-reset-code', [PasswordResetController::class, 'sendPasswordResetCode']);
Route::post('/verify-reset-code', [PasswordResetController::class, 'verifyResetCode']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

Route::prefix('auth')->group(function(){
    Route::post('/register' , [ AuthController::class , 'register']);
    Route::post('login' , [ AuthController::class , 'login']);
    Route::post('logout' , [ AuthController::class , 'logout']);
    Route::post('refresh' , [ AuthController::class , 'refresh']);
});

Route::middleware(['auth:api'])->group(function () {


    Route::resource('/categories' , CategoryController::class);
    Route::resource('/campanies' , CampanyController::class)->only('index');

    Route::resource('/products', ProductController::class)->only('index' , 'show' );
    Route::resource('/rates', ProductRateController::class);
    Route::resource('/carts', CartItemController::class);
    Route::resource('/orders', OrderController::class);

    Route::post('/orders/cancel/{id}', [OrderController::class, 'cancelOrder']);



});

    Route::post('/admin/register' , [ AuthAdminController::class , 'register']);
    Route::post('/admin/login' , [ AuthAdminController::class , 'login']);
    Route::post('/admin/logout' , [ AuthAdminController::class , 'logout']);

Route::middleware('auth:admin')->group(function () {
     Route::resource('/campanies' , CampanyController::class);
        Route::post('/campanies/{id}', [CampanyController::class, 'update']);
        Route::post('/deleteAccount/{id}', [UserController::class, 'deleteAccount']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::post('/products/{id}', [ProductController::class, 'update']);
        Route::resource('/admin/orders', OrderAdminController::class)->only('index' , 'destroy' ,'update');
});





