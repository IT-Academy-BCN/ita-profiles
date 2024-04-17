<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Student;
use App\Models\Resume;
use App\Service\Student\ModalityService;
use Tests\Fixtures\Students;
use App\Exceptions\ModalityNotFoundException;

class ModalityServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $modalityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modalityService = new modalityService();
    }

    public function testExecuteWithValidStudentId()
    {
        $student = Student::first();

        if (!$student) {
            $student = Students::aStudent();
        }
    
        $studentId = $student->id;

        $resume = Resume::where('student_id', $studentId)->first();

        $result = $this->modalityService->execute($student->id);

        $this->assertEquals($resume->modality, $result);
    }

    public function testExecuteWithInvalidStudentId()
    {
                
        $this->expectException(ModalityNotFoundException::class);

        $this->modalityService->execute('nonExistentStudentId');

    }

}