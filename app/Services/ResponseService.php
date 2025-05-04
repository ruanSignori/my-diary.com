<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
  /**
   * Return a formatted success response
   */
  public static function success($data = [], $code = 200, $headers = []): JsonResponse
  {
    return response()->json([
      'status' => 'success',
      'code' => $code,
      'data' => $data,
    ], $code, $headers);
  }

  public static function error($message = 'Error', $code = 500, $headers = []): JsonResponse
  {
    return response()->json([
      'status' => 'error',
      'code' => $code,
      'message' => $message,
    ], $code, $headers);
  }
}
