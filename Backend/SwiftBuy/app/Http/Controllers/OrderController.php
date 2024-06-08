<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items')->get();
        // $orders = Order::get();
        if($orders){
            return ApiResponse::sendResponse(200,"All Orders",$orders);
        }
        return ApiResponse::sendResponse(404,"Ca`nt find orders");

    }



    public function store(OrderRequest $request)
    {
        $request->validated();
        $order = Order::create($request->only(['user_id', 'date','status','total_price']));

        $total = [] ;
        if ($request->has('items')) {
            foreach ($request->items as $key => $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    return ApiResponse::sendResponse(404, 'Product not found');
                }
                $total [] = $item['quantity'] * $product->final_price ;
                $order->items()->create($item);
            }
        }
        $final = array_sum($total);

        $order->total_price = $final ;
        if (!$order->save()) {
            return ApiResponse::sendResponse(500, 'Failed to create order');
        }
        return ApiResponse::sendResponse(201, 'Order Created Successfully', $order->load('items'));
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        if($order){
            return ApiResponse::sendResponse(200, 'Order is',$order);
        }
        return ApiResponse::sendResponse(500, 'Can`t find this order');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $order = Order::find($id);

        if (is_null($order)) {
            return ApiResponse::sendResponse(404,"Order not found");
        }

        $order->fill($request->only(['user_id', 'date', 'total_price', 'status']));
        if($order->save()){
            return ApiResponse::sendResponse(200,"Updated Successfully",$order);
        }
        return ApiResponse::sendResponse(500,"Fait to Update");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order->delete()){
            return ApiResponse::sendResponse(204,"Order Deleted Successfully");
        }
        return ApiResponse::sendResponse(500,"Fail to delete");
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


    public function reject(string $id)
    {
        $order = Order::findOrFail($id);
        $order ->update(['status' => 'rejected']);
        return ApiResponse::sendResponse(200,"Orders ",$order);
    }


    public function accept(Request $request, string $id)
    {
        $order = Order::find($id);
        $order ->update(['status'=> 'accepted']);
        return ApiResponse::sendResponse(200,"Orders ",$order);
    }
}
