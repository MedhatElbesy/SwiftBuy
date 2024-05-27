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
    public function index(Request $request)
    {
        $products = Product::where(function($q) use($request){
            if ($request->search) {

                $q->where('title', 'LIKE', '%' . $request->search . '%');

            }
        })->
        get();
        if ($products) {
            return ApiResponse::sendResponse(200, 'All Products', $products);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest  $request)
    {
        $data = $request->validated();
        $product = Product::create($data);

        if($product)
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $product->cover_image = 'product/' . $imageName;
                $product->save();
            }
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
    public function update(ProductRequest $request, $id)
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
    /**
     * Search for products
     *
     * @param Request $request
     * @return $products
     */
    // public function search(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|min:1'
    //     ]);

    //     $searchQuery = $request->input('name');
    //     $products = Product::where('name', 'like', '%' . $searchQuery . '%')->get();

    //     if ($products->isEmpty()) {
    //         return response()->json(['message' => 'No products found'], 404);
    //     }

    //     return ApiResponse::sendResponse(200,"Product is",$products);
    // }
}
