<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\api\SpecializationListController;
use App\Service\SpecializationListService;

class SpecializationListControllerUnitTest extends TestCase
{
    protected $specializationListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->specializationListService = new SpecializationListService();
    }

    public function testSpecializationListControllerCanBeInstantiated(): void
    {

        $controller = new SpecializationListController($this->specializationListService);

        $this->assertInstanceOf(SpecializationListController::class, $controller);
    }
}
