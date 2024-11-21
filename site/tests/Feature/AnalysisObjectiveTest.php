<?php

namespace Tests\Feature;

use App\Models\AnalysisObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalysisObjectiveTest extends TestCase
{
    use RefreshDatabase;

    public function testAnalysisObjectiveCreation(): void
    {
        $analysisObjective = AnalysisObjective::factory()->create();

        $this->assertDatabaseHas('analysis_objectives', [
            'id' => $analysisObjective->id,
        ]);
    }

    public function testAnalysisObjectiveUpdate(): void
    {
        $analysisObjective = AnalysisObjective::factory()->create();
        $analysisObjective->update(['name' => 'updated']);

        $this->assertDatabaseHas('analysis_objectives', [
            'id' => $analysisObjective->id,
            'name' => 'updated',
        ]);
    }

    public function testAnalysisObjectiveDeletion(): void
    {
        $analysisObjective = AnalysisObjective::factory()->create();
        $analysisObjective->delete();

        $this->assertDatabaseMissing('analysis_objectives', [
            'id' => $analysisObjective->id,
        ]);
    }
}
