<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;

class ModalityTest extends TestCase
{
    use DatabaseTransactions;

    public function testModalityControllerReturns_200StatusForValidStudentUuidWithModality():void
    {
        $student = Students::aStudent();
        
        $studentId = $student->id;

        Resumes::createResumeWithModality($studentId, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $response = $this->getJson(route('modality', ['studentId' => $studentId]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['modality']);
    }

    public function testModalityControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentUuidWithoutResume():void
    {
        $student = Students::aStudent();
        
        $studentId = $student->id;

        $response = $this->getJson(route('modality', ['studentId' => $studentId]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $studentId]);
    }

    public function testModalityControllerReturns_404StatusAndStudentNotFoundExceptionMessageForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('modality', ['studentId' =>  'nonExistentStudentId']));
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonExistentStudentId']);
    }
}


