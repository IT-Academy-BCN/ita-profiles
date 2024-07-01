<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Tag;

use App\Models\Tag;
use App\Service\Tag\TagListService;
use App\ValueObjects\Tag\TagArray;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TagListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected TagListService $tagListService;

    protected function setUp(): void
    {
        parent::setUp();

        Tag::query()->delete();
        $this->tagListService = new TagListService(new TagArray());
    }

    public function testCanBeInstantiated(): void
    {
        self::assertInstanceOf(TagListService::class, $this->tagListService);
    }

    public function testCanReturnAValidTagsArrayWhenTagTableHasTags(): void
    {
        Tag::factory()->count(26)->create();

        $response = $this->tagListService->execute();

        $this->assertIsArray($response);
        $this->assertCount(26, $response);
    }

    public function testCanReturnAVoidTagsArrayWhenTagTableHasNoTags(): void
    {
        $response = $this->tagListService->execute();

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }
}
