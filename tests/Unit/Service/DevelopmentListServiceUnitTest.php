<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Service\DevelopmentListService;
use Tests\TestCase;

class DevelopmentListServiceUnitTest extends TestCase
{
    private $developmentListService;

    public function setUp(): void
    {
        parent::setUp();

        $this->developmentListService = new DevelopmentListService();
    }

    public function testDevelopmentListServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(DevelopmentListService::class, $this->developmentListService);
    }
}