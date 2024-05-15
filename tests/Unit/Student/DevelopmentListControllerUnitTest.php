<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\api\DevelopmentListController;
use App\Service\DevelopmentListService;

class DevelopmentListControllerUnitTest extends TestCase
{
    protected $developmentListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->developmentListService = new DevelopmentListService();
    }

    public function testDevelopmentListControllerCanBeInstantiated(): void
    {
        $controller = new DevelopmentListController($this->developmentListService);

        $this->assertInstanceOf(DevelopmentListController::class, $controller);
    }
}