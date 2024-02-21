<?php

namespace App\Http;

class ResponseHelper
{
    public static function response(int $status = 200, string $message, $data = null)
    {
        $response = [
            'status' => config('app.api_status') ? $status : 400,
            'message' => config('app.api_status') ? $message : 'API não está rodando.',
            'data' => config('app.api_status') ? $data : null,
        ];

        return response()->json($response, $status);
    }
}
