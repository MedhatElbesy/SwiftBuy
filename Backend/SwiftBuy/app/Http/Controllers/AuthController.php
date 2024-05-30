<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function register(UserRegisterRequest $request){

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photoName);
            $photoPath = 'user/' . $photoName;
        } else {
            $photoPath = null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => $photoPath,
            'gender'=>$request->gender
        ]);

        $data['token'] = $user->createToken("apitoken")->plainTextToken;
        $data['name'] = $user->name;
        $data['photo'] = $photoPath;
        return ApiResponse::sendResponse(200, "Register Success", $data);
    }

    public function login(UserLoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::sendResponse(401, "Fail data");
        }

        $token = $user->createToken('apitoken')->plainTextToken;

        $data = [
            'token' => $token,
            'name'  => $user->name,
            'email' => $user->email,
            'photo' => $user->photo,
        ];

        return ApiResponse::sendResponse(200, "Login Success", $data);
    }


    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,"Logedout Success");
    }
}


