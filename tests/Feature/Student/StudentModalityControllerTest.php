<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use App\Service\Student\StudentModalityService;
use App\Http\Controllers\api\StudentModalityController;

class StudentModalityControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStudentModalityControllerReturns_200StatusForValidStudentUuidWithModality():void
    {
        $student = Students::aStudent();
        
        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $response = $this->getJson(route('student.modality', ['studentId' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['modality']);
    }

    public function testStudentModalityControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume():void
    {
        $student = Students::aStudent();
        
        $studentId = $student->id;

        $response = $this->getJson(route('student.modality', ['studentId' => $studentId]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $studentId]);
    }

    public function testStudentModalityControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.modality', ['studentId' =>  'nonExistentStudentId']));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testStudentModalityControllerCanBeInstantiated():void
    {
        $studentModalityService = $this->createMock(StudentModalityService::class);
        
        $controller = new StudentModalityController($studentModalityService);

        $this->assertInstanceOf(StudentModalityController::class, $controller);
    }
}


