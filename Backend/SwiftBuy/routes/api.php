<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('api')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product_images', ProductImageController::class);
    Route::get('/categories/{id}/products', [CategoryController::class, 'getProducts']);
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::get('users/{user_id}/orders/{order_id}', [OrderController::class, 'getOrderForUser']);
    Route::get('users/{user_id}/orders', [OrderController::class, 'getOrdersForUser']);
    Route::get('products/search', [ProductController::class, 'search']);



});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




