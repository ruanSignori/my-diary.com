<?php

namespace App\Http\Controllers\Api\V1\Migrations;

use App\Http\Controllers\Controller;
use App\Services\MigrationsService;
use App\Services\ResponseService;

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

       return ResponseService::success([
        'migrations' => $doneMigrations
      ]);
    }
}
