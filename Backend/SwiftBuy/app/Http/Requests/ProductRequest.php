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
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for each image
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required and must be unique',
            'description.required' => 'A description is required',
            'status.required' => 'A status is required',
            'stock.required' => 'A stock image is required',
            'price.required' => 'A stock price is required',
            'category_id.required' => 'Category ID is required and must exist',
            'images.*.image' => 'The file must be an image',
            'images.*.mimes' => 'Only jpeg, png, jpg, and gif images are allowed',
            'images.*.max' => 'The image size cannot be greater than 2MB',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         'title'       => 'required|max:255|unique:products',
    //         'description' => 'required',
    //         'status'      => 'required',
    //         'price'       => 'required',
    //         'stock'       => 'required',
    //         'category_id' => [
    //             'required',
    //             Rule::exists('categories', 'id'),
    //         ],
    //     ];
    // }

    // public function messages(): array
    // {
    //     return [
    //         'title.required' => 'A title is required and Must be unique',
    //         'description.required' => 'A Description is required',
    //         'status.required' => 'A Status is required',
    //         'stock.required' => 'A stock image is required',
    //         'price.required' => 'A stock price is required',
    //         'category_id' => 'category id required and Must be exits'
    //     ];
    // }
}
