<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\SpecializationListService;
use Tests\TestCase;

class SpecializationListServiceUnitTest extends TestCase
{
    private $specializationListService;

    public function setUp(): void
    {
        parent::setUp();

        $this->specializationListService = new SpecializationListService();
    }

    public function testSpecializationServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(SpecializationListService::class, $this->specializationListService);
    }
}
