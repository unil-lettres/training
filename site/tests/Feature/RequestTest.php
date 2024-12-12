<?php

namespace Tests\Feature;

use App\Mail\RequestCreated;
use App\Models\Orientation;
use App\Models\Request;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_creation(): void
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

        $this->assertDatabaseHas('orientations', [
            'id' => $request->orientation_id,
        ]);
    }

    public function test_request_update(): void
    {
        $request = Request::factory()->create();

        $status = Status::factory()->create();
        $user = User::factory()->create();
        $orientation = Orientation::factory()->create();

        $request->update([
            'name' => 'updated',
            'status_id' => $status->id,
            'user_id' => $user->id,
            'orientation_id' => $orientation->id,
        ]);

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'name' => 'updated',
            'status_id' => $status->id,
            'user_id' => $user->id,
            'orientation_id' => $orientation->id,
        ]);
    }

    public function test_request_deletion(): void
    {
        $request = Request::factory()->create();
        $request->delete();

        $this->assertDatabaseMissing('requests', [
            'id' => $request->id,
        ]);
    }

    public function test_request_created_email_content(): void
    {
        $request = Request::factory()->create();

        $mailable = new RequestCreated($request);

        $mailable->assertSeeInHtml($request->user->name);
        $mailable->assertSeeInHtml($request->id);
        $mailable->assertSeeInHtml($request->name);
    }
}
