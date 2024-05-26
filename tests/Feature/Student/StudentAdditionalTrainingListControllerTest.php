<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use Tests\Fixtures\Students;
use App\Http\Controllers\api\AdditionalTrainingListController;
use App\Service\AdditionalTrainingService;

class StudentAdditionalTrainingListControllerTest extends TestCase
{
    public function test_it_returns_additional_training_details_for_valid_uuid()
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

    public function test_it_returns_404_for_invalid_uuid()
    {
        $response = $this->getJson(route('student.additionaltraining', ['studentId' => 'nonexistent_uuid']));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: nonexistent_uuid']);
    }

    public function test_it_returns_404_for_valid_uuid_without_resume()
    {
        $student = Students::aStudent();

        $studentId = $student->id;
        
        $response = $this->getJson(route('student.additionaltraining', ['studentId' => $studentId]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $studentId]);
    }

    public function testAdditionalTrainingListControllerCanBeInstantiated(): void
    {
        $additionalTrainingService = $this->createMock(AdditionalTrainingService::class);
        
        $controller = new AdditionalTrainingListController($additionalTrainingService);

        $this->assertInstanceOf(AdditionalTrainingListController::class, $controller);
    }

}