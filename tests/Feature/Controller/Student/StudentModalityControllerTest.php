<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;

class StudentModalityControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStudentModalityControllerReturns_200StatusForValidStudentUuidWithModality(): void
    {
        $student = Students::aStudent();
        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', [1, 3], 'Presencial');

        $response = $this->getJson(route('student.modality', ['student' => $studentId]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['modality']);
    }

    public function testStudentModalityControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume(): void
    {
        $student = Students::aStudent();
        $studentId = $student->id;

        $response = $this->getJson(route('student.modality', ['student' => $studentId]));

        $response->assertStatus(404);
    }

    public function testStudentModalityControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.modality', ['student' => 'nonExistentStudentId']));

        $response->assertStatus(404);
    }
}
