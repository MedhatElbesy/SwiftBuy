<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => ['required','string'],
            'email' => 'required|unique:admins,email',
            'password' => ['required'],
            'username' => ['nullable']
        ],[],[
            'name' => 'Name',
            'email' => 'Email',
            'password' > 'Password'
        ]);

        if($validator->fails()){
            return 'Fail Validation';
        }
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $data['token'] = $admin->createToken("apitoken")->plainTextToken;
        $data['name'] = $admin->name;
        return ApiResponse::sendResponse(200,"Register Success", $data);


    }

    public function login(Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:admins,email',
        'password' => 'required',
    ], [], [
        'email' => 'Email',
        'password' => 'Password',
    ]);

    if ($validator->fails()) {
        return ApiResponse::sendResponse(200, "Fail");
    }

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return ApiResponse::sendResponse(200, "Fail data");
    }

    $token = $admin->createToken('apitoken')->plainTextToken;

    $data = [
        'token' => $token,
        'name' => $admin->name,
    ];

    return ApiResponse::sendResponse(200, "Login Success For Admin", $data);
    }
    public function logout(Request $request){
        $request->user("admin-api")->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,"Logedout Success For Admin");
    }
}
