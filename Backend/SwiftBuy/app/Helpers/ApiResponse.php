<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Response;

class ApiResponse {
    static function sendResponse($code = 200, $msg = null, $data = null){

        $response = [
            'status' => $code,
            'msg'    => $msg,
            'data'   => $data
        ];

        return Response::json($response,$code);
    }
}
