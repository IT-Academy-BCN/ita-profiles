<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Service\AdditionalTrainingService;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;

class AdditionalTrainingListServiceTest extends TestCase
{
    protected $additionalTrainingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->additionalTrainingService = new AdditionalTrainingService();
    }

    /** @test */
    public function it_returns_additional_training_details_for_valid_uuid()
    {
        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);
                
        $additionalTraining1 = AdditionalTraining::factory()->create();
        $additionalTraining2 = AdditionalTraining::factory()->create();

        $resume->additional_trainings_ids = json_encode([$additionalTraining1->id, $additionalTraining2->id]);
        $resume->save();

        $result = $this->additionalTrainingService->getAdditionalTrainingDetails($student->id);

        $this->assertCount(2, $result);
        
    }

    /** @test */
    public function it_throws_model_not_found_exception_for_invalid_uuid()
    {
        
        $this->expectException(ModelNotFoundException::class);

        $this->additionalTrainingService->getAdditionalTrainingDetails('nonexistent_uuid');
    }

    /** @test */
    public function testGetAdditionalTrainingDetailsNoRecords()
    {
        
        $student = Student::factory()->create();

        $student->resume()->create();
        
        $service = new AdditionalTrainingService();

        $result = $service->getAdditionalTrainingDetails($student->id);
        $this->assertEmpty($result);
    }
}
