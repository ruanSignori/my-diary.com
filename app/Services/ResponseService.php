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
}
