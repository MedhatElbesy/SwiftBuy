<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        if ($categories) {
            return ApiResponse::sendResponse(200, 'All Categories', $categories);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();
        $record = Category::create($validatedData);

        if ($record) {
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $record->cover_image = 'category/' . $imageName;
                $record->save();
            }

            return ApiResponse::sendResponse(201, 'Category Created Successfully', $record);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Category::findOrFail($id);
        if ($data) {
            return ApiResponse::sendResponse(200, 'Category', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::sendResponse(404, 'Category not found');
        }

        $validatedData = $request->validated();

        $category->fill($validatedData);

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $category->cover_image = 'category/' . $imageName;
        }

        $category->save();

        return ApiResponse::sendResponse(200, 'Category updated successfully', $category);
    }









    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->cover_image) {
            $imagePath = public_path($category->cover_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $category->delete();

        return ApiResponse::sendResponse(200, 'Category Deleted Successfully');
    }

    public function getProducts($id){
        $category = Category::find($id);
        if($category){
            $products = $category->products;
            return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', $products);
        }
        return ApiResponse::sendResponse(404, 'Category Not Found');
    }
}
