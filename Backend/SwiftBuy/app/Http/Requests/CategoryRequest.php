<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // public function failedValidation(Validator $validator)
    // {
    //     if ($this->is('api/*')) {
    //         $response = ApiResponse::sendResponse(442, 'Validation Errors', $validator->errors()->all());
    //         throw new ValidationException($validator, $response);
    //     }
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|unique:categories|max:255',
            'description' => 'required',
            'status'      => 'required',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

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
