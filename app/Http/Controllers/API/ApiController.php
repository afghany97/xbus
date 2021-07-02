<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * @param array $payload
     * @param int $statusCode
     * @return JsonResponse
     */
    final public function response(array $payload, int $statusCode): JsonResponse
    {
        return response()->json($payload, $statusCode);
    }
}
