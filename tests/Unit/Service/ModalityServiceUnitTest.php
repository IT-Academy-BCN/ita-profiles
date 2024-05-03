<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\Student\ModalityService;
use Tests\TestCase;

class ModalityServiceUnitTest extends TestCase
{
    private $modalityService;

    public function setUp(): void
    {
        parent::setUp();

        $this->modalityService = new ModalityService();
    }

    public function testModalityServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(ModalityService::class, $this->modalityService);
    }
}
