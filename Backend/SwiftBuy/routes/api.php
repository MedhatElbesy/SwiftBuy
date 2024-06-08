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

Route::get('users/{user_id}/orders', [OrderController::class, 'getOrdersForUser']);

Route::group(["prefix" => "admin/"],function(){
    Route::controller(AdminController::class)->group(function () {

        //http://localhost:8000/api/admin/register
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:admin-api');
    });
        // Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        Route::get("orders/{id}/reject",[OrderController::class,'reject']);
        Route::get("orders/{id}/accept",[OrderController::class,'accept']);

    Route::group(["middleware" => "auth:admin-api"] , function() {
        // Route::resource('orders', OrderController::class);
        Route::resource('products', ProductController::class);
    });

});
// Route::put('orders',[OrderController::class,'update']);
Route::group(["prefix" => "user/"],function(){
    //http://localhost:8000/api/user/products must be login as user and featch with token

    // Route::resource('products', ProductController::class);
    Route::get('products', [ProductController::class, 'index']);
    // Route::resource('products', ProductController::class);
    Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::group(["middleware" => "auth:api"] , function(){

        Route::group(["middleware" => "auth:api"] , function(){
            Route::resource('carts',CartController::class);
        });

    // });
    // he

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

Route::resource("users",UserController::class);








