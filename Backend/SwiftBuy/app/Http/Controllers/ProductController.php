<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->merge(['promotion' => $request->input('promotion', 0)]);

        $data = $request->validated();
        $product = Product::create($request->only(['title','description','stock','price','	rating','status','category_id','created_at','updated_at','image','promotion']));

        $price = ($data['price'] -(($data['price'] * $data['promotion'])/100));
        $product->final_price = $price;

        $product->save();

        if($product)
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $product->image =$imageName;
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



    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return ApiResponse::sendResponse(404, 'Product not found');

        }

        $data = $request->validated();

        $oldImagePath = $product->image;
        dd($oldImagePath);

        $finalPrice = isset($data['price']) ? $data['price'] : $product->price;

        if (isset($data['promotion'])) {
            $finalPrice -= (($finalPrice * $data['promotion']) / 100);
        }

        $product->fill($request->only([
            'title', 'description', 'stock', 'rating', 'status', 'category_id', 'promotion'
        ]));
        $product->final_price = $finalPrice;

        if ($request->hasFile('image')) {
            if ($oldImagePath) {
                Storage::delete('public/images/' . $oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }
        $product->save();
        return ApiResponse::sendResponse(200, 'Product Updated Successfully', $product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // if ($product->image) {
        //     Storage::delete('public/images/' . $product->image);
        // }
        $product->delete();
        return ApiResponse::sendResponse(200, 'Product Deleted Successfully');
    }

}
