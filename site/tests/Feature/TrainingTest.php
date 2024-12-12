<?php

namespace Tests\Feature;

use App\Models\Training;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    use RefreshDatabase;

    public function test_training_creation(): void
    {
        $training = Training::factory()->create();

        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
        ]);
    }

    public function test_training_update(): void
    {
        $training = Training::factory()->create();
        $training->update(['name' => 'updated']);

        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
            'name' => 'updated',
        ]);
    }

    public function test_training_deletion(): void
    {
        $training = Training::factory()->create();
        $training->delete();

        $this->assertDatabaseMissing('trainings', [
            'id' => $training->id,
        ]);
    }
}
