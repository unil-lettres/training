<?php

namespace Tests\Feature;

use App\Models\Funding;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FundingTest extends TestCase
{
    use RefreshDatabase;

    public function test_funding_creation(): void
    {
        $funding = Funding::factory()->create();

        $this->assertDatabaseHas('fundings', [
            'id' => $funding->id,
        ]);
    }

    public function test_funding_update(): void
    {
        $funding = Funding::factory()->create();
        $funding->update(['name' => 'updated']);

        $this->assertDatabaseHas('fundings', [
            'id' => $funding->id,
            'name' => 'updated',
        ]);
    }

    public function test_funding_deletion(): void
    {
        $funding = Funding::factory()->create();
        $funding->delete();

        $this->assertDatabaseMissing('fundings', [
            'id' => $funding->id,
        ]);
    }
}
