<?php

namespace App\Http\Controllers\Api\V1\Status;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use App\Services\StatusService;

class StatusController extends Controller
{
  protected StatusService $statusService;

  public function __construct(StatusService $statusService)
  {
      $this->statusService = $statusService;
  }

  public function index()
  {
    return ResponseService::success([
      'server' => $this->statusService->getServerStatus(),
    ]);
  }
}
