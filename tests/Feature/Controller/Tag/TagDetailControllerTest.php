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

        $response = $this->getJson(route('tag.detail', ['tagId' => $tag->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'name' => $tag->name,
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

    public function testTagDetailControllerCanBeInstantiated()
    {
        $studentDetailService = $this->createMock(TagDetailService::class);

        $controller = new TagDetailController($studentDetailService);

        $this->assertInstanceOf(TagDetailController::class, $controller);
    }
}
