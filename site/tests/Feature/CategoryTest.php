<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryCreation(): void
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }

    public function testCategoryUpdate(): void
    {
        $category = Category::factory()->create();
        $category->update(['name' => 'updated']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'updated',
        ]);
    }

    public function testCategoryDeletion(): void
    {
        $category = Category::factory()->create();
        $category->delete();

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
