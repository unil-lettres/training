<?php

namespace Tests\Feature;

use App\Models\Request;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCreation(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function testUserUpdate(): void
    {
        $user = User::factory()->create();
        $user->update(['name' => 'updated']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'updated',
        ]);
    }

    public function testUserDeletion(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function testUserWithRelationshipDeletion(): void
    {
        $request = Request::factory()->create();
        $user = $request->user;

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'user_id' => $user->id,
        ]);

        $user->delete();

        $this->assertDatabaseHas('requests', [
            'id' => $request->id,
            'user_id' => null,
        ]);
    }
}
