<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use Tests\Fixtures\Students;
use App\Http\Controllers\api\Student\StudentAdditionalTrainingListController;
use App\Service\StudentAdditionalTrainingListService;

class StudentAdditionalTrainingListControllerTest extends TestCase
{
    public function testStudentAdditionalTrainingListControllerReturnsAdditionalTrainingDetailsForValidStudentUuid()
    {
        $student = Student::factory()->create();

        $resume = Resume::factory()->create(['student_id' => $student->id]); 

        $additionalTraining1 = AdditionalTraining::factory()->create();

        $additionalTraining2 = AdditionalTraining::factory()->create();

        $resume->additional_trainings_ids = json_encode([$additionalTraining1->id, $additionalTraining2->id]);

        $resume->save();

        $response = $this->getJson(route('student.additionaltraining', ['studentId' => $student->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['additional_trainings']);
    }

    public function testStudentAdditionalTrainingListControllerReturns_404ForInvalidStudentUuid()
    {
        $response = $this->getJson(route('student.additionaltraining', ['studentId' => 'nonexistent_uuid']));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonexistent_uuid']);
    }

    public function testStudentAdditionalTrainingListControllerReturns_404ForValidStudentUuidWithoutResume()
    {
        $student = Students::aStudent();

        $studentId = $student->id;
        
        $response = $this->getJson(route('student.additionaltraining', ['studentId' => $studentId]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $studentId]);
    }

    public function testStudentAdditionalTrainingListControllerCanBeInstantiated(): void
    {
        $additionalTrainingListService = $this->createMock(StudentAdditionalTrainingListService::class);
        
        $controller = new StudentAdditionalTrainingListController($additionalTrainingListService);

        $this->assertInstanceOf(StudentAdditionalTrainingListController::class, $controller);
    }

}