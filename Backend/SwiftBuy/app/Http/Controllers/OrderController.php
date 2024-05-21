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
        $orders = Order::all();
        return ApiResponse::sendResponse(200,'All Orders', $orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::create($data);

        if($order)
            return ApiResponse::sendResponse(201,'Order Created Successfully',$order );

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        if($order)
            return ApiResponse::sendResponse(200,'Order Is',$order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'date'        => 'required|date',
            'total_price' => 'required|numeric',
            'status'      => 'required|in:pending,completed',
        ]);

        $order->update($request->all());
        return ApiResponse::sendResponse(200,'Order Updated successfully',$order);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return ApiResponse::sendResponse(200,'Order Deleted successfully');
    }
}
