<?php

namespace Tests\Feature;

use App\Models\TrainingObjective;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingObjectiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_training_objective_creation(): void
    {
        $trainingObjective = TrainingObjective::factory()->create();

        $this->assertDatabaseHas('training_objectives', [
            'id' => $trainingObjective->id,
        ]);
    }

    public function test_training_objective_update(): void
    {
        $trainingObjective = TrainingObjective::factory()->create();
        $trainingObjective->update(['name' => 'updated']);

        $this->assertDatabaseHas('training_objectives', [
            'id' => $trainingObjective->id,
            'name' => 'updated',
        ]);
    }

    public function test_training_objective_deletion(): void
    {
        $trainingObjective = TrainingObjective::factory()->create();
        $trainingObjective->delete();

        $this->assertDatabaseMissing('training_objectives', [
            'id' => $trainingObjective->id,
        ]);
    }
}
