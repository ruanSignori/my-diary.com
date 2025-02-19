<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;

class MigrationsService
{
  /**
   * Execute the artisan command to show pending migrations
   * and return the output in a formatted array
   *
   * @return array
   */
  public static function showPendingMigrations()
  {
    Artisan::call('migrate:status');

    $output = Artisan::output();
    $outputFormatted = explode("\n", trim($output));

    $pending = [];
    foreach ($outputFormatted as $line) {
        if (!str_contains($line, 'Pending')) {
            continue;
        }

        $line = trim($line);

        $line = explode(' ', $line);

        $pending[] = [
            'migration' => $line[0],
            'status' => $line[2],
        ];
    }
    return $pending;
  }

  public static function runPendingMigrations()
  {
    Artisan::call('migrate');
    $output = Artisan::output();
    $outputFormatted = explode("\n", trim($output));

    $doneMigrations = [];
    foreach ($outputFormatted as $line) {
        if (!str_contains($line, 'DONE')) {
            continue;
        }

        $line = trim($line);

        $line = explode(' ', $line);

        $doneMigrations[] = [
            'migration' => $line[0],
            'execution_time' => $line[2],
            'status' => $line[3],
        ];
    }
    return $doneMigrations;
  }
}
