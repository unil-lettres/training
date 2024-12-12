<?php

namespace Tests\Feature;

use App\Models\AnalysisObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalysisObjectiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_analysis_objective_creation(): void
    {
        $analysisObjective = AnalysisObjective::factory()->create();

        $this->assertDatabaseHas('analysis_objectives', [
            'id' => $analysisObjective->id,
        ]);
    }

    public function test_analysis_objective_update(): void
    {
        $analysisObjective = AnalysisObjective::factory()->create();
        $analysisObjective->update(['name' => 'updated']);

        $this->assertDatabaseHas('analysis_objectives', [
            'id' => $analysisObjective->id,
            'name' => 'updated',
        ]);
    }

    public function test_analysis_objective_deletion(): void
    {
        $analysisObjective = AnalysisObjective::factory()->create();
        $analysisObjective->delete();

        $this->assertDatabaseMissing('analysis_objectives', [
            'id' => $analysisObjective->id,
        ]);
    }
}
