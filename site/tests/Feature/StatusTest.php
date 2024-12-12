<?php

namespace Tests\Feature;

use App\Models\Request;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_creation(): void
    {
        $status = Status::factory()->create();

        $this->assertDatabaseHas('statuses', [
            'id' => $status->id,
        ]);
    }

    public function test_status_update(): void
    {
        $status = Status::factory()->create();
        $status->update(['name' => 'updated']);

        $this->assertDatabaseHas('statuses', [
            'id' => $status->id,
            'name' => 'updated',
        ]);
    }

    public function test_status_deletion(): void
    {
        $status = Status::factory()->create();
        $status->delete();

        $this->assertDatabaseMissing('statuses', [
            'id' => $status->id,
        ]);
    }

    public function test_status_with_relationship_deletion(): void
    {
        $request = Request::factory()->create();
        $status = $request->status;

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'status_id' => $status->id,
        ]);

        $status->delete();

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'status_id' => null,
        ]);
    }
}
