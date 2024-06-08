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
            'title'        => 'sometimes|string|max:255',
            'description'  => 'sometimes|string',
            'stock'        => 'sometimes|string',
            'price'        => 'sometimes|numeric|min:0',
            'rating'       => 'sometimes|in:1,2,3,4,5',
            'status'       => 'sometimes|in:0,1',
            // 'category_id'  => 'sometimes|exists:categories,id',
            'image'        => 'nullable|',
            'promotion'    => 'nullable|string|max:255',
            'final_price'  => 'nullable|string|max:255',
        ];
    }
}

