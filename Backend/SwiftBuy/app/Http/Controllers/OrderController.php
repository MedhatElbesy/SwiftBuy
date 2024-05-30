<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $orders = Order::with('items')->get();
        $orders = Order::get();
        return ApiResponse::sendResponse(200,"All Orders",$orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $request->validated();
        $order = Order::create($request->only(['user_id', 'date','status']));

        $total = [] ;
        if ($request->has('items')) {
            foreach ($request->items as $key => $item) {
                $product = Product::find($item['product_id']);
                $total [] = $item['quantity'] * $product->final_price ;
                $order->items()->create($item);
            }
        }
        $final = array_sum($total);

        $order->total_price = $final ;
        $order->save();
        return ApiResponse::sendResponse(201,"Order Created Successfully",$order->load('items'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Order::with('items')->findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $order = Order::find($id);

        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->fill($request->only(['user_id', 'date', 'total_price', 'status']));
        $order->save();

        return ApiResponse::sendResponse(200,"Updated Successfully",$order);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return ApiResponse::sendResponse(204,"Order Deleted Successfully");
    }


    public function getOrderForUser($user_id, $order_id)
    {
        $order = Order::where('user_id', $user_id)->where('id', $order_id)->with('items')->first();

        if (!$order) {
            return ApiResponse::sendResponse(200,"Order Not Found");
        }
        return ApiResponse::sendResponse(200,"Order Is",$order);
    }

    public function getOrdersForUser($user_id)
    {
        $orders = Order::where('user_id', $user_id)->with('items')->get();

        if ($orders->isEmpty()) {
            return ApiResponse::sendResponse(200,"Orders Not Found");
        }

        return ApiResponse::sendResponse(200,"All Orders ",$orders);
    }
}
