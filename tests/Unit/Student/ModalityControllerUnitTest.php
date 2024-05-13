<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\ModalityController;
use App\Service\Student\ModalityService;

class ModalityControllerUnitTest extends TestCase
{
    public function testModalityControllerCanBeInstantiated():void
    {
        $modalityService = $this->createMock(ModalityService::class);
        
        $controller = new ModalityController($modalityService);

        $this->assertInstanceOf(ModalityController::class, $controller);
    }
}

