<?php

namespace Tests\Feature;

use App\Models\Tool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolTest extends TestCase
{
    use RefreshDatabase;

    public function test_tool_creation(): void
    {
        $tool = Tool::factory()->create();

        $this->assertDatabaseHas('tools', [
            'id' => $tool->id,
        ]);
    }

    public function test_tool_update(): void
    {
        $tool = Tool::factory()->create();
        $tool->update(['name' => 'updated']);

        $this->assertDatabaseHas('tools', [
            'id' => $tool->id,
            'name' => 'updated',
        ]);
    }

    public function test_tool_deletion(): void
    {
        $tool = Tool::factory()->create();
        $tool->delete();

        $this->assertDatabaseMissing('tools', [
            'id' => $tool->id,
        ]);
    }
}
