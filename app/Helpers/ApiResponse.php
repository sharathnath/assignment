<?php

namespace App\Helpers;

class ApiResponse
{
    public static function ok($status, $data = null, $message = null)
    {
        $result['status'] = $status;
        if (!empty($data)) {
            $result['data'] = $data;
        }

        if (!empty($message)) {
            $result['message'] = $message;
        }

        return response()->json($result, 200);
    }

    public static function unprocessableEntity($status, $error)
    {
        $result['status'] = $status;
        $result['message'] = $error;
        return response()->json($result, 422);
    }

    public static function unauthorized()
    {
        return response()->json(['message' => 'Authorization required'], 401);
    }

    public static function noContent()
    {
        return response()->json(['message' => 'No Content'], 204);
    }

    public static function notFound()
    {
        return response()->json(['message' => 'Model Not Found'], 404);
    }
}
