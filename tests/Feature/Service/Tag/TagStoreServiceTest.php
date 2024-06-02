<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Tag;

use Tests\TestCase;
use App\Models\Tag;
use App\Service\Tag\TagStoreService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagStoreServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected TagStoreService $tagStoreService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->tagStoreService = new TagStoreService();
    }

    public function testTagStoreServiceSuccesfullyCreatesANewTag(): void
    {
        $tagData = [
            'tag_name' => 'Test Tag'
        ];

        $tagResource = $this->tagStoreService->execute($tagData);

        $this->assertInstanceOf(Tag::class, $tagResource->resource);

        $this->assertEquals($tagData['tag_name'], $tagResource->tag_name);
    }

    public function testTagStoreServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(TagStoreService::class, $this->tagStoreService);
    }

}
