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
            'user_id'     => 'required|exists:users,id',
            'date'        => 'required|date',
            'total_price' => 'required|numeric',
            'status'      => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'A User Id is required',
            'total_price.required' => 'A Total Price is required',
            'status.required' => 'A Status is required',
        ];
    }
}
