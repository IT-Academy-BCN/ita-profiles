<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use App\Service\AdditionalTrainingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class AdditionalTrainingListControllerTest extends TestCase
{
    /** @test */
    public function it_returns_additional_training_details_for_valid_uuid()
    {
        
        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);        
        $additionalTraining1 = AdditionalTraining::factory()->create();
        $additionalTraining2 = AdditionalTraining::factory()->create();
        $resume->additional_trainings_ids = json_encode([$additionalTraining1->id, $additionalTraining2->id]);
        $resume->save();

        $this->app->instance(AdditionalTrainingService::class, new AdditionalTrainingService());

        $response = $this->getJson(route('student.additionaltraining', ['studentId' => $student->id]));

        $response->assertStatus(200)
                 ->assertJsonStructure(['additional_trainings']);
    }

    /** @test */
    public function it_returns_404_for_invalid_uuid()
    {
        $this->app->instance(AdditionalTrainingService::class, new AdditionalTrainingService());

        $response = $this->getJson(route('student.additionaltraining', ['studentId' => 'nonexistent_uuid']));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_500_for_internal_server_error()
    {
        
        $this->app->instance(AdditionalTrainingService::class, new class {
            public function getAdditionalTrainingDetails($uuid)
            {
                throw new Exception();
            }
        });

        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);        

        $response = $this->getJson(route('student.additionaltraining', ['studentId' => $student->id]));

        $response->assertStatus(500);
    }

}