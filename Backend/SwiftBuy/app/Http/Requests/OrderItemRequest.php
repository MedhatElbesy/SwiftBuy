<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required',
            'price'      => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required'   => 'A Order Id is required',
            'product_id.required' => 'A Product Id is required',
            'quantity.required'   => 'A Quantity is required',
            'price.required'      => 'A Price is required',
        ];
    }
}
