<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\Student;
use App\Models\Resume;
use App\Models\Collaboration;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentCollaborationDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    private Student $student;
    private Resume $resume;
    private Collaboration $collaboration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();

        $this->resume = Resume::factory()->create([
            'student_id' => $this->student->id
        ]);

        $this->collaboration = Collaboration::factory()->create([
            'collaboration_name' => 'Test Collaboration',
            'collaboration_description' => 'Test Description',
            'collaboration_quantity' => 1
        ]);

        $this->resume->collaborations()->attach($this->collaboration->id);
    }

    public function testStudentCollaborationDetailControllerReturns200StatusForValidStudent(): void
    {
        $response = $this->getJson(route('student.collaborations', ['student' => $this->student->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'collaborations' => [
                '*' => [
                    'uuid',
                    'collaboration_name',
                    'collaboration_description',
                    'collaboration_quantity'
                ]
            ]
        ]);
    }

    public function testStudentCollaborationDetailControllerReturnsEmptyArrayForStudentWithoutCollaborations(): void
    {
        $studentWithoutCollaborations = Student::factory()->create();
        $resume = Resume::factory()->create([
            'student_id' => $studentWithoutCollaborations->id
        ]);

        $response = $this->getJson(route('student.collaborations', ['student' => $studentWithoutCollaborations->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'collaborations' => []
        ]);
    }

    public function testStudentCollaborationDetailControllerReturns404ForValidStudentUuidWithoutResume(): void
    {
        $studentWithoutResume = Student::factory()->create();

        $response = $this->getJson(route('student.collaborations', ['student' => $studentWithoutResume->id]));

        $response->assertStatus(404);
    }

    public function testStudentCollaborationDetailControllerReturns404ForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.collaborations', ['student' => 'invalid-uuid']));

        $response->assertStatus(404);
    }
}
