<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => 'required|unique:users,email',
            'password' => ['required'],
            'username' => ['nullable'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'gender'=>['required','in:male,female']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'This email is already taken',
            'password.required' => 'Password is required',
            'photo.image' => 'The photo must be an image',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, jpg, gif',
            'photo.max' => 'The photo may not be greater than 2048 kilobytes',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'photo' => 'Photo',
        ];
    }
}
