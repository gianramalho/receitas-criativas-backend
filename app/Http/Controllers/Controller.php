<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function validateRequest($data, $attributes, $rules, $messages = [])
    {
        return Validator::make($data, $rules, $messages, $attributes);
    }

    protected function validationErrorResponse($validator)
    {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    protected function successResponse($data, $message = "")
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], 200);
    }

    protected function notFoundResponse($message)
    {
        return response()->json([
            'message' => $message
        ], 404);
    }
}
