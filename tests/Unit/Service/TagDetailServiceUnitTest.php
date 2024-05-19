<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\TagDetailService;
use Tests\TestCase;

class TagDetailServiceUnitTest extends TestCase
{
    private $tagDetailService;

    public function setUp(): void
    {
        parent::setUp();

        $this->tagDetailService = new TagDetailService();
    }

    public function testTagDetailServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(TagDetailService::class, $this->tagDetailService);
    }
}
