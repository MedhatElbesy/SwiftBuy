<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items')->get();
        return ApiResponse::sendResponse(200,"All Orders",$orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $request->validated();
        $order = Order::create($request->only(['user_id', 'date', 'total_price', 'status']));

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $order->items()->create($item);
            }
        }
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
    public function update(Request $request,$id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:0,1',
            'items' => 'array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.order_id' => 'required|exists:orders,id',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric'
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->only(['user_id', 'date', 'total_price', 'status']));

        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $order->items()->updateOrCreate(
                    ['id' => $itemData['id'] ?? null],
                    $itemData
                );
            }
        }
        return ApiResponse::sendResponse(204,"Order Updated Successfully",$order->load('items'));
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
