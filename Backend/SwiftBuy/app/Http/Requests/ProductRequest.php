<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'title'       => 'required|max:255|unique:products',
            'description' => 'required',
            'status'      => 'required',
            'price'       => 'required',
            'stock'       => 'required',
            'image'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'promotion'   => 'nullable',
            // 'category_id' => ['required',
            //     Rule::exists('categories', 'id'),
            // ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'A title is required and must be unique',
            'description.required' => 'A description is required',
            'status.required'      => 'A status is required',
            'stock.required'       => 'A stock image is required',
            'price.required'       => 'A stock price is required',
            // 'category_id.required' => 'Category ID is required and must exist',
        ];
    }

}
