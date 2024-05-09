<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\StudentDetailController;
use App\Service\StudentDetailService;

class StudentDetailControllerUnitTest extends TestCase
{
    public function testStudentDetailControllerCanBeInstantiated()
    {
        $studentDetailService = $this->createMock(StudentDetailService::class);
        
        $controller = new StudentDetailController($studentDetailService);

        $this->assertInstanceOf(StudentDetailController::class, $controller);
    }
}

