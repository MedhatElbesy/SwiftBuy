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


    public function login(Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:admins,email',
        'password' => 'required',
    ], [], [
        'email' => 'Email',
        'password' => 'Password',
    ]);

    if ($validator->fails()) {
        return ApiResponse::sendResponse(401, "Fail");
    }

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return ApiResponse::sendResponse(401, "Fail data");
    }

    $token = $admin->createToken('apitoken')->plainTextToken;

    $data = [
        'token' => $token,
        'name' => $admin->name,
        'id' => $admin->id,
        'email' => $admin->email,
    ];

    return ApiResponse::sendResponse(200, "Login Success For Admin", $data);
    }
    public function logout(Request $request){
        $request->user("admin-api")->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,"Logedout Success For Admin");
    }
}
