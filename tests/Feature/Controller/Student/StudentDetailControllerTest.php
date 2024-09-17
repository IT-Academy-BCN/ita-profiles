<?php

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Student;

class StudentDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();
        $this->resume = $this->student->resume()->create();
    }

    public function testStudentDetailsAreFound(): void
    {
        $response = $this->get(route('student.details', ['student' => $this->student]));

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $this->student->id,
        ]);
    }

    public function testStudentDetailsIsNotFound(): void
    {
        $nonExistentStudentId = 12345;

        $response = $this->get(route('student.details', ['student' => $nonExistentStudentId]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] ' . $nonExistentStudentId]);
    }

    public function testStudentDetailControllerReturns_404StatusAndResumeNotFoundExceptionMessageForValidStudentWithoutResume(): void
    {
        $this->student->resume->delete();

        $response = $this->get(route('student.details', ['student' => $this->student]));

        $response->assertStatus(404);

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $this->student->id]);
    }
}
