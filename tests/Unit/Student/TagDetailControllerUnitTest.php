<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\TagDetailController;
use App\Service\TagDetailService;

class tagDetailControllerUnitTest extends TestCase
{
    public function testTagDetailControllerCanBeInstantiated()
    {
        $studentDetailService = $this->createMock(TagDetailService::class);
        
        $controller = new TagDetailController($studentDetailService);

        $this->assertInstanceOf(TagDetailController::class, $controller);
    }
}

