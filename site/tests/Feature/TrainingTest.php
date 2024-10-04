<?php

namespace Tests\Feature;

use App\Models\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    use RefreshDatabase;

    public function testTrainingCreation(): void
    {
        $training = Training::factory()->create();

        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
        ]);
    }

    public function testTrainingUpdate(): void
    {
        $training = Training::factory()->create();
        $training->update(['name' => 'updated']);

        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
            'name' => 'updated',
        ]);
    }

    public function testTrainingDeletion(): void
    {
        $training = Training::factory()->create();
        $training->delete();

        $this->assertDatabaseMissing('trainings', [
            'id' => $training->id,
        ]);
    }
}
