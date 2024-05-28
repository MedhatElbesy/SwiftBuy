<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItem = Order::with('items')->get();
        return ApiResponse::sendResponse(200,"All Order Details",$orderItem);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd(33);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:0,1',
            'items' => 'array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric'
        ]);



        $total_price = 0 ;
        foreach($request->items as $key => $item){
            dd($item);
        }
        $order = Order::create($request->only(['user_id', 'date', 'status']));
        $order->total_price = $total_price ;

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $order->items()->create($item);
            }
        }

        return response()->json($order->load('items'), 201);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:0,1',
            'items' => 'array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric'
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->only(['user_id', 'date', 'total_price', 'status']));

        // Update or create items
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                $order->items()->updateOrCreate(
                    ['id' => $itemData['id'] ?? null],
                    $itemData
                );
            }
        }

        return response()->json($order->load('items'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}
