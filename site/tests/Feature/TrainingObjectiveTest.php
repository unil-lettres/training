<?php

namespace Tests\Feature;

use App\Models\TrainingObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingObjectiveTest extends TestCase
{
    use RefreshDatabase;

    public function testTrainingObjectiveCreation(): void
    {
        $trainingObjective = TrainingObjective::factory()->create();

        $this->assertDatabaseHas('training_objectives', [
            'id' => $trainingObjective->id,
        ]);
    }

    public function testTrainingObjectiveUpdate(): void
    {
        $trainingObjective = TrainingObjective::factory()->create();
        $trainingObjective->update(['name' => 'updated']);

        $this->assertDatabaseHas('training_objectives', [
            'id' => $trainingObjective->id,
            'name' => 'updated',
        ]);
    }

    public function testTrainingObjectiveDeletion(): void
    {
        $trainingObjective = TrainingObjective::factory()->create();
        $trainingObjective->delete();

        $this->assertDatabaseMissing('training_objectives', [
            'id' => $trainingObjective->id,
        ]);
    }
}
