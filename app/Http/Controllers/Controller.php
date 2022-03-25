<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function jsonResponse($message = '', $data = '', $errors = '', $status = 200) {
        return response()->json(['message' => $message, 'data' => $data, 'errors' => $errors], $status);
    }

    public function success($message = '', $data = null, $status = Response::HTTP_OK) {
        $response = [
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $status);
    }

    public function error($status, $message, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($response, $status);
    }
}
