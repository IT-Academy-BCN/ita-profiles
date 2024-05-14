<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Service\AdditionalTrainingService;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Tests\Fixtures\Students;

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
    public function it_returns_additional_training_details_for_valid_uuid(): void
    {
        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);
                
        $additionalTraining1 = AdditionalTraining::factory()->create();
        $additionalTraining2 = AdditionalTraining::factory()->create();

        $resume->additional_trainings_ids = json_encode([$additionalTraining1->id, $additionalTraining2->id]);
        $resume->save();

        $result = $this->additionalTrainingService->execute($student->id);

        $this->assertCount(2, $result);
        
    }

    /** @test */
    public function it_throws_student_not_found_exception_for_invalid_uuid(): void
    {
        
        $this->expectException(StudentNotFoundException::class);

        $this->additionalTrainingService->execute('nonexistent_uuid');
    }

    /** @test */
    public function it_throws_resume_not_found_exception_for_valid_uuid(): void
    {

        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->additionalTrainingService->execute($studentId);
    }

    /** @test */
    public function testGetAdditionalTrainingDetailsNoRecords(): void
    {
        
        $student = Student::factory()->create();

        $student->resume()->create();
        
        $service = new AdditionalTrainingService();

        $result = $service->execute($student->id);
        $this->assertEmpty($result);
    }
    
}
