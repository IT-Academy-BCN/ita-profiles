<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\StudentListController;
use App\Service\StudentListService;

class StudentListControllerUnitTest extends TestCase
{
    public function testStudentListControllerCanBeInstantiated()
    {
        $studentListService = $this->createMock(StudentListService::class);
        
        $controller = new StudentListController($studentListService);

        $this->assertInstanceOf(StudentListController::class, $controller);
    }
}

