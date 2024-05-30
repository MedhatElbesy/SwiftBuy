<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'        => 'sometimes|required|string|max:255',
            'description'  => 'sometimes|required|string',
            'stock'        => 'sometimes|required|string',
            'price'        => 'sometimes|required|numeric|min:0',
            'rating'       => 'sometimes|required|in:1,2,3,4,5',
            'status'       => 'sometimes|required|in:0,1',
            'category_id'  => 'sometimes|required|exists:categories,id',
            'image'        => 'nullable|',
            'promotion'    => 'nullable|string|max:255',
            'final_price'  => 'nullable|string|max:255',
        ];
    }
}

