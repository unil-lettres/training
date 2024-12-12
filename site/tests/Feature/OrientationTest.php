<?php

namespace Tests\Feature;

use App\Models\Orientation;
use App\Models\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrientationTest extends TestCase
{
    use RefreshDatabase;

    public function test_orientation_creation(): void
    {
        $orientation = Orientation::factory()->create();

        $this->assertDatabaseHas('orientations', [
            'id' => $orientation->id,
        ]);
    }

    public function test_orientation_update(): void
    {
        $orientation = Orientation::factory()->create();
        $orientation->update(['name' => 'updated']);

        $this->assertDatabaseHas('orientations', [
            'id' => $orientation->id,
            'name' => 'updated',
        ]);
    }

    public function test_orientation_deletion(): void
    {
        $orientation = Orientation::factory()->create();
        $orientation->delete();

        $this->assertDatabaseMissing('orientations', [
            'id' => $orientation->id,
        ]);
    }

    public function test_orientation_with_relationship_deletion(): void
    {
        $request = Request::factory()->create();
        $orientation = $request->orientation;

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'orientation_id' => $orientation->id,
        ]);

        $orientation->delete();

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'orientation_id' => null,
        ]);
    }
}
