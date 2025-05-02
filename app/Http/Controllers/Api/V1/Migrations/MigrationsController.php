<?php

namespace App\Http\Controllers\Api\V1\Migrations;

use App\Http\Controllers\Controller;
use App\Services\MigrationsService;
use App\Services\ResponseService;
use Illuminate\Http\Response;

class MigrationsController extends Controller
{
    public function index()
    {
      $pendingMigrations = MigrationsService::showPendingMigrations();

       return ResponseService::success([
        'migrations' => $pendingMigrations
      ]);
    }

    public function store()
    {
      $doneMigrations = MigrationsService::runPendingMigrations();
      $statusCode = count($doneMigrations) > 0 ? Response::HTTP_CREATED : RESPONSE::HTTP_OK;

       return ResponseService::success([
        'migrations' => $doneMigrations
      ], $statusCode);
    }
}
