<?php

namespace Tests\Feature;

use App\Models\Funding;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FundingTest extends TestCase
{
    use RefreshDatabase;

    public function testFundingCreation(): void
    {
        $funding = Funding::factory()->create();

        $this->assertDatabaseHas('fundings', [
            'id' => $funding->id,
        ]);
    }

    public function testFundingUpdate(): void
    {
        $funding = Funding::factory()->create();
        $funding->update(['name' => 'updated']);

        $this->assertDatabaseHas('fundings', [
            'id' => $funding->id,
            'name' => 'updated',
        ]);
    }

    public function testFundingDeletion(): void
    {
        $funding = Funding::factory()->create();
        $funding->delete();

        $this->assertDatabaseMissing('fundings', [
            'id' => $funding->id,
        ]);
    }
}
