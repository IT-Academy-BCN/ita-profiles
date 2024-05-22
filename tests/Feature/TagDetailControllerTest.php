<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Tests\TestCase;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TagDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testInvokeReturnsExpectedData(): void
    {
        $tag = Tag::factory()->create([
            'tag_name' => 'Test Tag',
        ]);

        $response = $this->getJson(route('tag.detail', ['tagId' => $tag->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'tag_name' => $tag->tag_name,
                'created_at' => $tag->created_at->toISOString(),
                'updated_at' => $tag->updated_at->toISOString(),
            ],
        ]);
    }

    public function testInvokeReturnsNotFoundForNonExistentTag(): void
    {
        $nonExistentTagId = 9999;

        $response = $this->getJson(route('tag.detail', ['tagId' => $nonExistentTagId]));

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Tag not found with id '.$nonExistentTagId,
        ]);
    }
}
