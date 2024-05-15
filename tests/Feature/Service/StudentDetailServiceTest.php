<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use App\Models\Resume;
use App\Service\StudentDetailService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Student;
use Tests\Fixtures\Students;

class StudentDetailServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentDetailService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentDetailService = new StudentDetailService();
    }
    public function testGetStudentDetailsById() : void
    {
        $service = $this->studentDetailService;

        $resume = Resume::factory()->create();

        $result = $service->getStudentDetailsById($resume->student->id);

        $this->assertEquals($resume->about, $result["about"]);

    }

    public function testStudentDetailsNotFound() : void
    {
        $service = new StudentDetailService();

        $nonExistentStudentId = 'non-existent-student-id';

        $this->expectException(StudentNotFoundException::class);
        $service->getStudentDetailsById($nonExistentStudentId);
    }

    public function testCollaborationServiceThrowsResumeNotFoundExceptionForstudentWithoutResume(): void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->studentDetailService->execute($studentId);
    }

}