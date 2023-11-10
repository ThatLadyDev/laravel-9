<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiResponse extends Response
{
    /**
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public static function success(array $data = [], int $status = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'data' => $data,
        ];

        return parent::json($response, $status);
    }

    /**
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public static function error(string $message, int $status = 400): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        return parent::json($response, $status);
    }
}
