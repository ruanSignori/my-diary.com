<?php

namespace App\Http\Controllers\Api\V1\Status;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class StatusController extends Controller
{
  public function index(): JsonResponse
  {
    $server = [
      'version' => phpversion(),
      'timezone' => date_default_timezone_get(),
      'current_timestamp' =>  date('Y-m-d H:i:s')
    ];

     $response = [
      'server' => $server
    ];
    return response()->json($response, 200);
  }
}
