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
            return ApiResponse::sendResponse(201, 'Category Created Successfully', $categories);
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
        $category = Category::findOrFail($id);
        $validatedData = $request->validated();
        $category->update($validatedData);
        return ApiResponse::sendResponse(200, 'Category Updated Successfully', $category);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        if($category)
            return ApiResponse::sendResponse(200, 'Category Deleted Successfully');
    }
}
