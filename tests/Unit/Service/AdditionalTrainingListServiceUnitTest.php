<?php

namespace tests\Unit\Service;

use App\Service\AdditionalTrainingService;
use Tests\TestCase;

class AdditionalTrainingListServiceUnitTest extends TestCase
{
    private $additionalTrainingService;

    public function setUp(): void
    {
        parent::setUp();

        $this->additionalTrainingService = new AdditionalTrainingService();
    }

    public function testCollaborationServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(AdditionalTrainingService::class, $this->additionalTrainingService);
    }


}
