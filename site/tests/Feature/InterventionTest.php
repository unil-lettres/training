<?php

namespace Tests\Feature;

use App\Models\Intervention;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterventionTest extends TestCase
{
    use RefreshDatabase;

    public function testInterventionCreation(): void
    {
        $intervention = Intervention::factory()->create();

        $this->assertDatabaseHas('interventions', [
            'id' => $intervention->id,
        ]);
    }

    public function testInterventionUpdate(): void
    {
        $intervention = Intervention::factory()->create();
        $intervention->update(['name' => 'updated']);

        $this->assertDatabaseHas('interventions', [
            'id' => $intervention->id,
            'name' => 'updated',
        ]);
    }

    public function testInterventionDeletion(): void
    {
        $intervention = Intervention::factory()->create();
        $intervention->delete();

        $this->assertDatabaseMissing('interventions', [
            'id' => $intervention->id,
        ]);
    }
}
