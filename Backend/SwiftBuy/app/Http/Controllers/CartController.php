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
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            // Retrieve the user's cart items
            $carts = Cart::where('user_id', $user->id)->get();
            return ApiResponse::sendResponse(200, 'Cart is found', $carts);
        } else {
            // Return an unauthorized response if the user is not authenticated
            return ApiResponse::sendResponse(401, 'Not authorized');
        }
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
        // dd($user = Auth::user()->id);
        $user = Auth::user();



        
        $cart = Cart::where('user_id', $user->id)
        ->where('product_id', $request->product_id)
        ->first();

        if ($cart) {
        $cart->quantity += $request->quantity;
        $cart->save();
        } else {
        $cart = Cart::updateOrCreate([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);
        }
        return ApiResponse::sendResponse(200, 'Cart is created', $cart);
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
        return ApiResponse::sendResponse(200, 'Cart Item  is deleted', $cart);
    }
}
