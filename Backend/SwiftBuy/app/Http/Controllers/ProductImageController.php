<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $images = $request->file('image');
        $product_id = $request->input('product_id'); 

        $imagePaths = [];

        foreach($images as $image){
            $newName = rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $newName);
            $imagePaths[] = 'images/'.$newName;
        }

        foreach ($imagePaths as $image) {
            $productImage = new ProductImage();
            $productImage->image = $image;
            $productImage->product_id = $product_id ;
            $productImage->save();
        }

        return ApiResponse::sendResponse(200, 'Images uploaded successfully', $imagePaths);
    }

}
