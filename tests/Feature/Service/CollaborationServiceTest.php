<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use App\Service\CollaborationService;
use App\Models\Student;
use App\Models\Collaboration;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Tests\Fixtures\Students;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class CollaborationServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $collaborationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collaborationService = new CollaborationService();
    }

    public function testCollaborationServiceReturnsValidCollaborationDetailsForStudentWithCollaborations(): void
    {
        $student = Student::factory()->create();

        $resume = $student->resume()->create();

        $collaboration1 = Collaboration::factory()->create();

        $collaboration2 = Collaboration::factory()->create();

        $resume->collaborations_ids = json_encode([$collaboration1->id, $collaboration2->id]);

        $resume->save();

        $response = $this->collaborationService->execute($student->id);

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

        $service = new CollaborationService();

        $response = $service->execute($student->id);

        $this->assertIsArray($response);
        
        $this->assertEmpty($response);
    }

    public function testCollaborationServiceThrowsStudentNotFoundExceptionIfRecievesNonExistentStudendId(): void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->collaborationService->execute('nonexistent_uuid');
    }

    public function testCollaborationServiceThrowsResumeNotFoundExceptionForstudentWithoutResume(): void
    {
        $student = Students::aStudent();

        $studentId = $student->id;

        $this->expectException(ResumeNotFoundException::class);

        $this->collaborationService->execute($studentId);
    }

    public function testCollaborationServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(CollaborationService::class, $this->collaborationService);
    }

}
