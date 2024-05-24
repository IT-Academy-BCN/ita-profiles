<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use App\Service\StudentCollaborationService;
use App\Models\Student;
use App\Models\Collaboration;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Tests\Fixtures\Students;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentCollaborationServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentCollaborationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentCollaborationService = new StudentCollaborationService();
    }

    public function testCollaborationServiceReturnsValidCollaborationDetailsForStudentWithCollaborations(): void
    {
        $student = Student::factory()->create();

        $resume = $student->resume()->create();

        $collaboration1 = Collaboration::factory()->create();

        $collaboration2 = Collaboration::factory()->create();

        $resume->collaborations_ids = json_encode([$collaboration1->id, $collaboration2->id]);

        $resume->save();

        $response = $this->studentCollaborationService->execute($student->id);

        $this->assertIsArray($response);

        $this->assertCount(2, $response);

        $expectedKeys = ['uuid', 'collaboration_name', 'collaboration_description', 'collaboration_quantity'];
        
        foreach ($response as $collaborationDetails) {
            foreach ($expectedKeys as $key) {
                $this->assertArrayHasKey($key, $collaborationDetails);
            }
        }
    }

    public function testCollaborationServiceReturnsAnEmptyArrayInCaseOfStudentWithoutCollaborations(): void
    {
        $student = Student::factory()->create();

        $student->resume()->create();

        $service = new StudentCollaborationService();

        $response = $service->execute($student->id);

        $this->assertIsArray($response);
        
        $this->assertEmpty($response);
    }

    public function testCollaborationServiceThrowsStudentNotFoundExceptionIfRecievesNonExistentStudendId(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->studentCollaborationService->execute('nonexistent_uuid');
    }

    public function testCollaborationServiceThrowsResumeNotFoundExceptionForstudentWithoutResume(): void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->studentCollaborationService->execute($studentId);
    }

    public function testCollaborationServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentCollaborationService::class, $this->studentCollaborationService);
    }

}
