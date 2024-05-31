<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'date' => 'sometimes|required|date',
            'total_price' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:pending,accepted,rejected',
        ];
    }
}
