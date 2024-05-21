<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\OrderItemRequest;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItem = OrderItem::all();
        return ApiResponse::sendResponse(200,"All Order Details",$orderItem);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderItemRequest $request)
    {
        // $data = $request->validated();
        // $product = OrderItem::create($data);

        // if($product)
        //     return ApiResponse::sendResponse(201,'ProductItem Created Successfully',$product );
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
