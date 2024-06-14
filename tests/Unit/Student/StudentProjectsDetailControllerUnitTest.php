<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\api\StudentProjectsDetailController;
use App\Service\Student\StudentProjectsDetailService;

class StudentProjectsDetailControllerUnitTest extends TestCase
{
    protected $projectsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectsService = new StudentProjectsDetailService();
    }
    public function testStudentProjectsDetailControllerCanBeInstantiated()
    {

        $controller = new StudentProjectsDetailController($this->projectsService);

        $this->assertInstanceOf(StudentProjectsDetailController::class, $controller);
    }
}
