<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use App\Service\Student\ModalityService;
use App\Http\Controllers\api\ModalityController;

class ModalityTest extends TestCase
{
    use DatabaseTransactions;

    public function testModalityControllerReturns_200StatusForValidStudentUuidWithModality():void
    {
        $student = Students::aStudent();
        
        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $response = $this->getJson(route('student.modality', ['studentId' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['modality']);
    }

    public function testModalityControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume():void
    {
        $student = Students::aStudent();
        
        $studentId = $student->id;

        $response = $this->getJson(route('student.modality', ['studentId' => $studentId]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $studentId]);
    }

    public function testModalityControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.modality', ['studentId' =>  'nonExistentStudentId']));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }

    public function testModalityControllerCanBeInstantiated():void
    {
        $modalityService = $this->createMock(ModalityService::class);
        
        $controller = new ModalityController($modalityService);

        $this->assertInstanceOf(ModalityController::class, $controller);
    }
}


