<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function getOrderForUser($user_id, $order_id)
    {
        $order = Order::where('user_id', $user_id)->where('id', $order_id)->with('items')->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
