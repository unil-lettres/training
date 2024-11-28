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

    public function testGuestAccess(): void
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/request/create');
    }

    public function testUserAccess(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/request');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/request/create');
        $response->assertStatus(200);

        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->actingAs($user)->get('/admin');
    }

    public function testAdminUserAccess(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function testSuperEditorUserAccess(): void
    {
        $superEditor = User::factory()->superEditor()->create();

        $response = $this->actingAs($superEditor)->get('/admin');
        $response->assertStatus(200);

        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->actingAs($superEditor)->get('/admin/users');
    }
}
