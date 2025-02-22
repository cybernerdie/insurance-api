<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function success(string $message = 'Success', mixed $data = [], $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = 'Error', $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public static function forbidden($message = 'Forbidden', $data = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], 403);
    }

    public static function unauthorized($message = 'Unauthorized', $data = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], 401);
    }

    public static function validationError($errors, $message = 'Validation errors')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    public static function badRequest($message = 'Bad request', $data = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], 400);
    }

    public static function tooManyRequests($message = 'Too many requests, please try again later')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 429);
    }

    public static function internalServerError($message = 'Internal server error')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 500);
    }
}
