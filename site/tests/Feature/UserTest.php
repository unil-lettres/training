<?php

namespace Tests\Feature;

use App\Models\Request;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_update(): void
    {
        $user = User::factory()->create();
        $user->update(['name' => 'updated']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'updated',
        ]);
    }

    public function test_user_deletion(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_with_relationship_deletion(): void
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

    public function test_guest_access(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/request');

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/request/create');

        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->get('/admin');
    }

    public function test_user_access(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/request');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/request/create');
        $response->assertStatus(200);

        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->actingAs($user)->get('/admin');
    }

    public function test_super_editor_user_access(): void
    {
        $superEditor = User::factory()->superEditor()->create();

        $response = $this->actingAs($superEditor)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($superEditor)->get('/request');
        $response->assertStatus(200);

        $response = $this->actingAs($superEditor)->get('/request/create');
        $response->assertStatus(200);

        $response = $this->actingAs($superEditor)->get('/admin');
        $response->assertStatus(200);

        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->actingAs($superEditor)->get('/admin/users');
    }

    public function test_admin_user_access(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/request');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/request/create');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
    }
}
