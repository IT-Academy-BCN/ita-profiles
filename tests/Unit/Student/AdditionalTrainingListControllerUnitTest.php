<?php

declare(strict_types=1);

namespace tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\AdditionalTrainingListController;
use App\Service\AdditionalTrainingService;

class AdditionalTrainingListControllerUnitTest extends TestCase
{
    protected $additionalTrainingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->additionalTrainingService = new AdditionalTrainingService();
    }

    public function testAdditionalTrainingListControllerCanBeInstantiated(): void
    {
        $controller = new AdditionalTrainingListController($this->additionalTrainingService);

        $this->assertInstanceOf(AdditionalTrainingListController::class, $controller);
    }
}
