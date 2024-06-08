<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }




    public function messages(): array
    {
        return [
            'name.required' => 'A Name is required',
            'description.required' => 'A Description is required',
            'status.required' => 'A Status is required',
            'cover_image.required' => 'A Cover image is required',
        ];
    }
}
