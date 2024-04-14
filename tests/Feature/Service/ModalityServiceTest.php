<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Student;
use App\Models\Resume;
use App\Service\Student\ModalityService;
use Tests\Fixtures\Students;
use Exception;

class ModalityServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testExecuteWithValidStudentId()
    {
        $student = Student::first();

        if (!$student) {
            $student = Students::aStudent();
        }
    
        $studentId = $student->id;

        $resume = Resume::where('student_id', $studentId)->first();

        $modalityService = new ModalityService();

        $result = $modalityService->execute($student->id);

        $this->assertEquals($resume->modality, $result);
    }

    public function testExecuteWithInvalidStudentId()
    {
        $nonExistentStudentId = 9999;
        
        $modalityService = new ModalityService();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('No se encontró el currículum del usuario'));
        $this->expectExceptionCode(404);

        $modalityService->execute($nonExistentStudentId);
    }

}