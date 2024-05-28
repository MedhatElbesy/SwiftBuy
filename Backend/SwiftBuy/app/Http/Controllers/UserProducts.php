<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Product;
use Illuminate\Http\Request;

class UserProducts extends Controller
{
    public function index()
    {
        $products = Product::get();
        if ($products) {
            return ApiResponse::sendResponse(200, 'All Products', $products);
        }
    }
}
