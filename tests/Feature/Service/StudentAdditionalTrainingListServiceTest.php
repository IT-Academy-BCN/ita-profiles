<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use App\Service\StudentAdditionalTrainingService;
use App\Models\Student;
use App\Models\Resume;
use App\Models\AdditionalTraining;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Tests\Fixtures\Students;

class StudentAdditionalTrainingListServiceTest extends TestCase
{
    protected $studentAdditionalTrainingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentAdditionalTrainingService = new StudentAdditionalTrainingService();
    }

    public function test_it_returns_additional_training_details_for_valid_uuid(): void
    {
        $student = Student::factory()->create();

        $resume = Resume::factory()->create(['student_id' => $student->id]);
                
        $additionalTraining1 = AdditionalTraining::factory()->create();

        $additionalTraining2 = AdditionalTraining::factory()->create();

        $resume->additional_trainings_ids = json_encode([$additionalTraining1->id, $additionalTraining2->id]);

        $resume->save();

        $result = $this->studentAdditionalTrainingService->execute($student->id);

        $this->assertCount(2, $result);
    }

    public function test_it_throws_student_not_found_exception_for_invalid_uuid(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->studentAdditionalTrainingService->execute('nonexistent_uuid');
    }

    public function test_it_throws_resume_not_found_exception_for_valid_uuid(): void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->studentAdditionalTrainingService->execute($studentId);
    }

    public function test_get_additional_training_details_no_records(): void
    {
        $student = Student::factory()->create();

        $student->resume()->create();
        
        $service = new StudentAdditionalTrainingService();

        $result = $service->execute($student->id);
        
        $this->assertEmpty($result);
    }

    public function testAdditionalTrainingListServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentAdditionalTrainingService::class, $this->studentAdditionalTrainingService);
    }
    
}
