<?php

namespace Tests\Feature;

use App\Models\Intervention;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterventionTest extends TestCase
{
    use RefreshDatabase;

    public function test_intervention_creation(): void
    {
        $intervention = Intervention::factory()->create();

        $this->assertDatabaseHas('interventions', [
            'id' => $intervention->id,
        ]);
    }

    public function test_intervention_update(): void
    {
        $intervention = Intervention::factory()->create();
        $intervention->update(['name' => 'updated']);

        $this->assertDatabaseHas('interventions', [
            'id' => $intervention->id,
            'name' => 'updated',
        ]);
    }

    public function test_intervention_deletion(): void
    {
        $intervention = Intervention::factory()->create();
        $intervention->delete();

        $this->assertDatabaseMissing('interventions', [
            'id' => $intervention->id,
        ]);
    }
}
