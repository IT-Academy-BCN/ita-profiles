<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\ModalityService;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;

class ModalityServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $modalityService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->modalityService = new modalityService();
    }

    public function testExecuteWithValidStudentId(): void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $result = $this->modalityService->execute($studentId);

        $this->assertIsArray($result);
    }

    public function testServiceHandlesStudentWithoutModality():void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        Resumes::createResumeWithoutModality($studentId, 'frontend', ['tag1', 'tag2']);

        $result = $this->modalityService->execute($studentId);

        $this->assertIsArray($result);

        $this->assertEmpty($result);
    }


    public function testExecuteWithInvalidStudentId():void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->modalityService->execute('nonExistentStudentId');
    }

    public function testExecuteThrowsExceptionForStudentWithoutResume():void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->modalityService->execute($studentId);
    }
}