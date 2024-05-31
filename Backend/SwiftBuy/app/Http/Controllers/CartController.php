<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Auth::user();
        // if($user){
            // $carts = Cart::where('user_id', $user->id)->get();
        $carts = Cart::where('user_id', 2)->get();
        return ApiResponse::sendResponse(200, 'Cart is found', $carts);
        // }
        // else{
        // return ApiResponse::sendResponse(400, 'Not autherized');
        // }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
        ]);
        // $user = Auth::user();

        // $cart = Cart::where('user_id', $user->id)
        // $user = Auth::user();

        $user = Auth::user();
        // dd($user);
        // $cart = Cart::where('user_id', $user->id)
        $cart = Cart::where('user_id', 2)
        ->where('product_id', $request->product_id)
        ->first();

        if ($cart) {
        $cart->quantity += $request->quantity;
        $cart->save();
        } else {
        $cart = Cart::updateOrCreate([
            // 'user_id' => $user->id,
            'user_id' => 2,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);
        }
        return ApiResponse::sendResponse(200, 'Cart is created', $cart);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
        ]);

       // $user = Auth::user();
        $cart = Cart::where('user_id', 2)->findOrFail($id);

        if ($request->has('quantity')) {
            $cart->quantity = $request->quantity;
        }
        if ($request->has('product_id')) {
            $cart->product_id = $request->product_id;
        }
        $cart->save();

        return ApiResponse::sendResponse(200, 'Cart item updated successfully', $cart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cart=Cart::findOrFail($id);
        $cart->delete();
        return ApiResponse::sendResponse(200, 'Cart is deleted', $cart);
    }
}
