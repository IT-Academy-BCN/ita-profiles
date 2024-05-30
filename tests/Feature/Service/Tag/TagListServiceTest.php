<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Tag;
use App\Service\Tag\TagListService;


class TagListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $tagListService;

    protected function setUp(): void
    {
        parent::setUp();

        Tag::query()->delete();
        
        $this->tagListService = new TagListService();
    }

    public function testTagListServiceReturnsAValidTagsArrayWhenTagTableHasTags(): void
    {
        Tag::factory()->count(26)->create();

        $response = $this->tagListService->execute();

        $this->assertIsArray($response);
        
        $this->assertCount(26, $response);
    }

    public function testTagListServiceReturnsAVoidTagsArrayWhenTagTableHasNoTags(): void
    {
        $response = $this->tagListService->execute();

        $this->assertIsArray($response);

        $this->assertCount(0, $response);
    }

    public function testTagListServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(TagListService::class, $this->tagListService);
    }
}
