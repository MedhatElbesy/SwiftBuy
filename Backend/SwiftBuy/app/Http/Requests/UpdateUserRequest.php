<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|required|string|min:8',
            'gender' => 'sometimes|required|in:male,female',
            'photo' => 'nullable|string',
        ];
    }
}
