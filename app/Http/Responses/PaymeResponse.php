<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class PaymeResponse
{
    public function success(array $result): JsonResponse
    {
        return response()->json([
            'json' => '2.0',
            'result' => $result
        ]);
    }

    public function error(array $error): JsonResponse
    {
        return response()->json([
            'jsonrpc' => '2.0',
            'error' => $error
        ]);
    }

}
