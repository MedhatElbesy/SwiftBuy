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
        if($users){
            return ApiResponse::sendResponse('200','All users',$users);
        }
        return ApiResponse::sendResponse(404, 'There are no  Users');
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiResponse::sendResponse(404, "User not found");
        }
        return ApiResponse::sendResponse(200, "User retrieved successfully", $user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->fill($request->only(['name', 'email', 'gender', 'photo']));
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return ApiResponse::sendResponse(200,"Updated Successfully",$user);
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
