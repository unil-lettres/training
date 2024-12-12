<?php

namespace Tests\Feature;

use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * A basic test.
     */
    public function test_basic_test(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
