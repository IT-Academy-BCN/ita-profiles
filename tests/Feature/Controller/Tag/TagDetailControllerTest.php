<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Tag\TagDetailController;
use App\Service\Tag\TagDetailService;

class TagDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testInvokeReturnsExpectedData(): void
    {
        $tag = Tag::factory()->create([
            'name' => 'Test Tag',
        ]);

        $response = $this->getJson(route('tag.detail', ['tag' => $tag->id]));

        $response->assertStatus(200);
        
        $response->assertJson([
            'id' => $tag->id,
            'name' => $tag->name,
        ]);
    }

    public function testInvokeReturnsNotFoundForNonExistentTag(): void
    {
        $nonExistentTagId = 9999;

        $response = $this->getJson(route('tag.detail', ['tag' => $nonExistentTagId]));

        $response->assertStatus(404);
        
        $response->assertJson([
            'message' => 'No query results for model [App\\Models\\Tag] ' . $nonExistentTagId,
        ]);
    }

    public function testTagDetailControllerCanBeInstantiated()
    {
        $tagDetailService = $this->createMock(TagDetailService::class);

        $controller = new TagDetailController($tagDetailService);

        $this->assertInstanceOf(TagDetailController::class, $controller);
    }

    public function testInvokeReturnsTagsOfDifferentTypes(): void
{
    $tag1 = Tag::factory()->create(['name' => 'Unique Tag PHP']);
    $tag2 = Tag::factory()->create(['name' => 'Unique Tag Laravel']);

    $tags = [$tag1, $tag2];

    foreach ($tags as $tag) {
        $response = $this->getJson(route('tag.detail', ['tag' => $tag->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $tag->id,
            'name' => $tag->name,
        ]);
    }
}

}