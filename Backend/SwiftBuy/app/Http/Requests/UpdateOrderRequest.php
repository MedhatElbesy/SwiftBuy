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
            'user_id' => 'sometimes|exists:users,id',
            'date' => 'sometimes|date',
            'total_price' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:pending,accepted,rejected',
        ];
    }
}
