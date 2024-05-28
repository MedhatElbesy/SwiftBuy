<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\TextUI\XmlConfiguration\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::get();

        return ApiResponse::sendResponse('200','All users',$users);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::sendResponse(404, "User not found");
        }
        return ApiResponse::sendResponse(200, "User retrieved successfully", $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::sendResponse(404, "User not found");
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'gender'=> 'required'
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(400, "Validation Error", $validator->errors());
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return ApiResponse::sendResponse(200, "User updated successfully", $user);
    }

    public function getOrderForUser($user_id, $order_id)
    {
        $order = Order::where('user_id', $user_id)->where('id', $order_id)->with('items')->first();

        if (!$order) {
            ApiResponse::sendResponse(200,"Order Notfound");
        }

        ApiResponse::sendResponse(200,"Order",$order);
    }
}
