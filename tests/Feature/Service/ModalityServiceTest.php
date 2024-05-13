<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\ModalityService;
use Tests\Fixtures\Students;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;



use Tests\Fixtures\Resumes;

class ModalityServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $modalityService;// por que es protected y no private

    protected function setUp(): void
    {
        parent::setUp();
        $this->modalityService = new modalityService();
    }

    public function testExecuteWithValidStudentId():void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $resume = Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $result = $this->modalityService->execute($student->id);

        $this->assertEquals($resume->modality, $result);
    }

    public function testServiceHandlesStudentWithoutModality():void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        Resumes::createResumeWithoutModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $result = $this->modalityService->execute($student->id);

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

    $this->expectException(ResumeNotFoundException::class);
    $this->modalityService->execute($student->id);
}
}