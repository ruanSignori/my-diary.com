<?php

namespace App\Http\Controllers\Api\V1\Status;

use App\Http\Controllers\Controller;
use App\Services\StatusService;
use Illuminate\Http\JsonResponse;

class StatusController extends Controller
{
  protected StatusService $statusService;

  public function __construct(StatusService $statusService)
  {
      $this->statusService = $statusService;
  }

  public function index(): JsonResponse
  {
    $response = [
        'status' => 'success',
        'data' => [
            'server' => $this->statusService->getServerStatus(),
        ],
    ];

    return response()->json($response, 200);
  }
}
