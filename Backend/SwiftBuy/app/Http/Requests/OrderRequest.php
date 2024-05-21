<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:0,1',
            'items' => 'array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.order_id' => 'required|exists:orders,id',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric'
        ];
    }

}
