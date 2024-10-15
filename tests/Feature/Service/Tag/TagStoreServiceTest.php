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
            'name' => 'Test Tag'
        ];

        $tagResource = $this->tagStoreService->execute($tagData);

        $this->assertInstanceOf(Tag::class, $tagResource->resource);

        $this->assertEquals($tagData['name'], $tagResource->name);
    }

    public function testTagStoreServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(TagStoreService::class, $this->tagStoreService);
    }

}
