<?php

namespace Tests\Feature;

use App\Models\Orientation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrientationTest extends TestCase
{
    use RefreshDatabase;

    public function testOrientationCreation(): void
    {
        $orientation = Orientation::factory()->create();

        $this->assertDatabaseHas('orientations', [
            'id' => $orientation->id,
        ]);
    }

    public function testOrientationUpdate(): void
    {
        $orientation = Orientation::factory()->create();
        $orientation->update(['name' => 'updated']);

        $this->assertDatabaseHas('orientations', [
            'id' => $orientation->id,
            'name' => 'updated',
        ]);
    }

    public function testOrientationDeletion(): void
    {
        $orientation = Orientation::factory()->create();
        $orientation->delete();

        $this->assertDatabaseMissing('orientations', [
            'id' => $orientation->id,
        ]);
    }
}
