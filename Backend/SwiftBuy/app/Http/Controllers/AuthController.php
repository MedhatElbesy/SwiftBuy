<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => ['required','string'],
            'email' => ['required'],
            'password' => ['required']
        ],[],[
            'name' => 'Name',
            'email' => 'Email',
            'password' > 'Password'
        ]);

        if($validator->fails()){
            return 'no';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email)
        ]);
        $data['token'] = $user->createToken("apitoken")->plainTextToken;
        $data['name'] = $user->name;
        // return $data;
        return ApiResponse::sendResponse(200,"Register Success", $data);


    }

    public function login(Request $request){

        $validator = Validator::make($request->all(),
        [
            'email' => ['required'],
            'password' => ['required']
        ],[],[
            'email' => 'Email',
            'password' > 'Password'
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(200,"Fail");
        }

        $user = User::find([
            'email' => $request->email,
            'password' => Hash::make($request->email)
        ]);

        if(Auth::attempt(['email' => $request->email,'password' => $request->email])){
            $user = Auth::user();
            $data['token'] = $user->createToken("apitoken")->plainTextToken;
            $data['name'] = $user->name;
            return ApiResponse::sendResponse(200,"Login Success", $data);
        }else{
            return ApiResponse::sendResponse(200,"Fail data");
        }


    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,"Logedout Success");
    }
}
