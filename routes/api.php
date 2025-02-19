<?php

use App\Http\Controllers\Api\V1\Status\StatusController;
use App\Http\Controllers\Api\V1\Migrations\MigrationsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
  Route::get('/status', [StatusController::class, 'index']);

  Route::prefix('migrations')->group(function () {
      Route::get('/', [MigrationsController::class, 'index']);
      Route::post('/', [MigrationsController::class, 'store']);
  });
});
