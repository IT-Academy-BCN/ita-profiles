<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\StudentBootcampDetailController;
use App\Service\Student\studentBootcampDetailService;

class StudentBootcampDetailControllerUnitTest extends TestCase
{
    protected $studentBootcampDetailService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentBootcampDetailService = new studentBootcampDetailService();
    }

    public function testStudentBootcampDetailControllerCanBeInstantiated()
    {

        $controller = new StudentBootcampDetailController($this->studentBootcampDetailService);

        $this->assertInstanceOf(StudentBootcampDetailController::class, $controller);
    }
}
