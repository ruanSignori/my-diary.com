<?php

namespace Tests\Feature\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('api')]
class MigrationTest extends TestCase
{
  use RefreshDatabase;

  public function test_method_get_should_return_status_200(): void
  {
      $response = $this->get('/api/v1/migrations');

      $response->assertStatus(200);
  }

  public function test_all_pending_migrations_are_applied_returns_status_201(): void
  {
      # RefreshDatabase faz com que todas as migrations sejam executdas, por isso o rollback
      Artisan::call('migrate:rollback');

      $response = $this->post('/api/v1/migrations');

      $response->assertStatus(201)
               ->assertJsonPath('data.migrations', fn ($migration) =>
                  count($migration) > 0);
  }


  public function test_all_migrations_are_applied(): void
  {
    $response = $this->post('/api/v1/migrations');
    $response->assertStatus(200);
  }
}
