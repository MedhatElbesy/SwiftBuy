<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PermisionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum','api')->group(function () {
    Route::resource('carts',CartController::class);
    Route::get('user/products',[ProductController::class, 'index']);
});


Route::prefix('api')->middleware(['auth:sanctum','api','web'])->group(function () {
    Route::resource('categories', CategoryController::class);
    // Route::get('user/products',[ProductController::class, 'index']);
    Route::resource('product_images', ProductImageController::class);
    Route::get('/categories/{id}/products', [CategoryController::class, 'getProducts']);
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::get('users/{user_id}/orders/{order_id}', [OrderController::class, 'getOrderForUser']);
    Route::get('users/{user_id}/orders', [OrderController::class, 'getOrdersForUser']);


    // Route::get('products/search', [ProductController::class, 'search']);
});

Route::group(["prefix" => "admin/"],function(){
    Route::controller(AdminController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:admin-api');
    });

Route::group(["middleware" => "auth:admin-api"] , function(){
    Route::resource('products', ProductController::class);

});

});

Route::group(["prefix" => "user/"],function(){
    Route::controller(AuthController::class)->group(function (){
        Route::post('register','register');
        Route::post('login','login');
        Route::post('logout','logout')->middleware('auth:sanctum');
    });
});











