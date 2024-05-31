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
        return ApiResponse::sendResponse(200,"All Orders",$orders);
    }



    // public function store(OrderRequest $request)
    // {
    //     $request->validated();
    //     $order = Order::create($request->only(['user_id', 'date','status','total_price']));

    //     $total = [] ;
    //     if ($request->has('items')) {
    //         foreach ($request->items as $key => $item) {
    //             $product = Product::find($item['product_id']);
    //             $total [] = $item['quantity'] * $product->final_price ;
    //             $order->items()->create($item);
    //         }
    //     }
    //     $final = array_sum($total);

    //     $order->total_price = $final ;
    //     $order->save();
    //     return ApiResponse::sendResponse(201,"Order Created Successfully",$order->load('items'));
    // }

    /**
     * Display the specified resource.
     */



    public function store(OrderRequest $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $userId,
                'date' => $validated['date'],
                'status' => $validated['status'],
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $itemTotalPrice = $item['quantity'] * $product->final_price;
                $total += $itemTotalPrice;

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->final_price,
                ]);
            }

            $order->total_price = $total;
            $order->save();

            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return ApiResponse::sendResponse(201, "Order Created Successfully", $order->load('items'));

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::sendResponse(500, "Order Creation Failed", $e->getMessage());
        }
    }



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
            return ApiResponse::sendResponse(404,"Order not found");
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


    public function reject(string $id)
    {

            $Order = Order::findOrFail($id);
            $Order ->update(['status' => 'rejected']);
            return response()->json($Order,202);
    }


    public function accept(Request $request, string $id)
    {
        $Order = Order::find($id);
        $Order ->update(['status'=> 'accepted']);
        return response()->json($Order,200);
    }
}
