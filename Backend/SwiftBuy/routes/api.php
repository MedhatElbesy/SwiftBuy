<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PermisionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\UserController;
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
// Route::middleware('auth:sanctum','api')->group(function () {
    // Route::resource('carts',CartController::class);
    // Route::get('user/products',[ProductController::class, 'index']);
// });


// Route::prefix('api')->middleware(['auth:sanctum','api','web'])->group(function () {
// Route::prefix('api')->group(function () {
//     Route::post('user/products', [ProductController::class, 'store']);
    // Route::resource('categories', CategoryController::class);
    // Route::get('user/products',[ProductController::class, 'index']);
    // Route::resource('product_images', ProductImageController::class);
    // Route::get('/categories/{id}/products', [CategoryController::class, 'getProducts']);
    // Route::resource('orders', OrderController::class);
    // Route::resource('order-items', OrderItemController::class);
    // Route::get('users/{user_id}/orders/{order_id}', [OrderController::class, 'getOrderForUser']);
    // Route::get('user', [ProductController::class, 'search']);
    // Route::get('users/{user_id}/orders', [OrderController::class, 'getOrdersForUser']);
    // Route::get('user', [ProductController::class, 'search']);0
// });

// Route::prefix('api')->group(function () {
//     Route::post('user/products', [ProductController::class, 'store']);
// });


Route::get('users/{user_id}/orders', [OrderController::class, 'getOrdersForUser']);
Route::group(["prefix" => "admin/"],function(){
    Route::controller(AdminController::class)->group(function () {
        //http://localhost:8000/api/admin/register
        Route::post('register', 'register');
        //http://localhost:8000/api/admin/login
        Route::post('login', 'login');
        //http://localhost:8000/api/admin/logout must be login as user and logout with token
        Route::post('logout', 'logout')->middleware('auth:admin-api');
    });
    Route::get("orders/{id}/reject",[OrderController::class,'reject']);
    Route::get("orders/{id}/accept",[OrderController::class,'accept']);
    // Route::group(["middleware" => "auth:admin-api"] , function(){

        // http://localhost:8000/api/admin/products must be login as admin and send token to featch
        Route::resource('products', ProductController::class);
        //http://localhost:8000/api/admin/categories must be login as admin and send token to featch
        Route::resource('categories', CategoryController::class);
        //http://localhost:8000/api/admin/orders  must be login as admin and send token to featch

        Route::resource('orders', OrderController::class);
    // });

});
// Route::put('orders',[OrderController::class,'update']);
Route::group(["prefix" => "user/"],function(){
    //http://localhost:8000/api/user/products must be login as user and featch with token

    // Route::resource('products', ProductController::class);
    Route::get('products', [ProductController::class, 'index']);
    // Route::resource('products', ProductController::class);
    Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::group(["middleware" => "auth:api"] , function(){

    Route::resource('carts',CartController::class);

    // });

    Route::controller(AuthController::class)->group(function (){
        //http://localhost:8000/api/user/register
        Route::post('register','register');
        //http://localhost:8000/api/user/login
        Route::post('login','login');
        //http://localhost:8000/api/user/login must be login as user and logout with token
        Route::post('logout','logout')->middleware('auth:sanctum');
    });
});

Route::resource('orders', OrderController::class);

Route::get('users/{user_id}/orders', [OrderController::class, 'getOrdersForUser']);
Route::resource("users",UserController::class);








