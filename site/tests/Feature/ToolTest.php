<?php

namespace Tests\Feature;

use App\Models\Tool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolTest extends TestCase
{
    use RefreshDatabase;

    public function testToolCreation(): void
    {
        $tool = Tool::factory()->create();

        $this->assertDatabaseHas('tools', [
            'id' => $tool->id,
        ]);
    }

    public function testToolUpdate(): void
    {
        $tool = Tool::factory()->create();
        $tool->update(['name' => 'updated']);

        $this->assertDatabaseHas('tools', [
            'id' => $tool->id,
            'name' => 'updated',
        ]);
    }

    public function testToolDeletion(): void
    {
        $tool = Tool::factory()->create();
        $tool->delete();

        $this->assertDatabaseMissing('tools', [
            'id' => $tool->id,
        ]);
    }
}
