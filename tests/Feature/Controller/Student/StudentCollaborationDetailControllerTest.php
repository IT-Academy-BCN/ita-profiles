<?php

namespace Tests\Feature\Controller\Student;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCollaborationDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::with('resume.collaborations')->firstOrFail();
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
        $studentWithoutCollaborations = Student::doesntHave('resume.collaborations')->firstOrFail();

        $response = $this->getJson(route('student.collaborations', ['student' => $studentWithoutCollaborations->id]));

        $response->assertStatus(200);

        $response->assertJson([
            'collaborations' => []
        ]);
    }

    public function testStudentCollaborationDetailControllerReturns404ForValidStudentUuidWithoutResume(): void
    {
        $studentWithoutResume = Student::doesntHave('resume')->firstOrFail();

        $response = $this->getJson(route('student.collaborations', ['student' => $studentWithoutResume->id]));

        $response->assertStatus(404);
    }

    public function testStudentCollaborationDetailControllerReturns404ForInvalidStudentUuid(): void
    {
        $response = $this->getJson(route('student.collaborations', ['student' => 'invalid-uuid']));

        $response->assertStatus(404);
    }
}
