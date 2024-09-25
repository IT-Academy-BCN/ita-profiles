<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\StudentModalityService;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class StudentModalityServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentModalityService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentModalityService = new StudentModalityService();
    }

    public function testExecuteWithValidStudentId(): void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', [2, 7], 'Presencial');

        $result = $this->studentModalityService->execute($studentId);

        $this->assertIsArray($result);
    }

    public function testServiceHandlesStudentWithoutModality():void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        Resumes::createResumeWithoutModality($studentId, 'frontend', [9, 10]);

        $result = $this->studentModalityService->execute($studentId);

        $this->assertIsArray($result);

        $this->assertEmpty($result);
    }

    public function testExecuteWithInvalidStudentId():void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->studentModalityService->execute('nonExistentStudentId');
    }

    public function testExecuteThrowsExceptionForStudentWithoutResume():void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->studentModalityService->execute($studentId);
    }

    public function testModalityServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentModalityService::class, $this->studentModalityService);
    }

}
