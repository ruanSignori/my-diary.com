<?php

namespace Tests\Feature\Feature\Api\V1;
use PHPUnit\Framework\Attributes\Group;

use Tests\TestCase;

#[Group('api')]
class StatusTest extends TestCase
{
    public function test_method_get_should_return_status_200(): void
    {
        $response = $this->get('/api/v1/status');

        $response->assertStatus(200);
    }
}
