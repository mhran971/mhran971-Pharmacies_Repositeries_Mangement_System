<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    public function sendResponse($response, $status = "Success", $code = "200")
    {
        return response()->json(
            [
                'data' => $response,
                'status' => $status,
            ],
            $code
        );
    }

    public function sendError($message, $status = "Failed", $code = "401")
    {
        return response()->json(
            [
                'data' => $message,
                'status' => $status,
                'code' => $code,
            ],
            $code
        );
    }
}
