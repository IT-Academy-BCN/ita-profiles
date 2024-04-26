<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Service\CollaborationService;
use App\Models\Student;
use App\Models\Resume;
use App\Models\Collaboration;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;

class CollaborationServiceTest extends TestCase
{
    protected $collaborationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->collaborationService = new collaborationService();
    }

    /** @test */
    public function it_returns_collaboration_details_for_valid_uuid()
    {
        $student = Student::factory()->create();
        $resume = Resume::factory()->create(['student_id' => $student->id]);

        $collaboration1 = Collaboration::factory()->create();
        $collaboration2 = Collaboration::factory()->create();

        $resume->collaborations_ids = json_encode([$collaboration1->id, $collaboration2->id]);
        $resume->save();

        $result = $this->collaborationService->getCollaborationDetails($student->id);

        $this->assertCount(2, $result);

    }

    /** @test */
    public function it_throws_model_not_found_exception_for_invalid_uuid()
    {

        $this->expectException(ModelNotFoundException::class);

        $this->collaborationService->getCollaborationDetails('nonexistent_uuid');
    }

    /** @test */
    public function testGetCollaborationDetailsNoRecords()
    {

        $student = Student::factory()->create();

        $student->resume()->create();

        $service = new CollaborationService();

        $result = $service->getCollaborationDetails($student->id);
        $this->assertEmpty($result);
    }
}
