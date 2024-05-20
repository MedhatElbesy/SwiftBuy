<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        if ($products) {
            return ApiResponse::sendResponse(201, 'All Products', $products);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        if($product)
            return ApiResponse::sendResponse(201,'Product Created Successfully',$product );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        if($product)
            return ApiResponse::sendResponse(200,'Product',$product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $request->validated();
        $product->update($validatedData);
        return ApiResponse::sendResponse(200, 'Product Updated Successfully', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        if($product)
            return ApiResponse::sendResponse(200,'Product Deleted Successfully');
    }
}
