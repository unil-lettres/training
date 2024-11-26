<?php

namespace Tests\Feature;

use App\Models\Request;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    public function testRequestCreation(): void
    {
        $request = Request::factory()->create();

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
        ]);

        $this->assertDatabaseHas('statuses', [
            'id' => $request->status_id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $request->user_id,
        ]);
    }

    public function testRequestUpdate(): void
    {
        $request = Request::factory()->create();

        $status = Status::factory()->create();
        $user = User::factory()->create();

        $request->update([
            'name' => 'updated',
            'status_id' => $status->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'name' => 'updated',
            'status_id' => $status->id,
            'user_id' => $user->id,
        ]);
    }

    public function testRequestDeletion(): void
    {
        $request = Request::factory()->create();
        $request->delete();

        $this->assertDatabaseMissing('requests', [
            'id' => $request->id,
        ]);
    }
}
