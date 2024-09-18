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

    public function testStudentDetailsJsonFormat(): void
    {
        $response = $this->get(route('student.details', ['student' => $this->student]));

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $this->student->id,
            'fullname' => ucfirst($this->student->name) . ' ' . ucfirst($this->student->surname),
            'photo' => $this->student->photo,
            'status' => ucfirst($this->student->status),
            'resume' => [
                'subtitle' => $this->resume->subtitle,
                'social_media' => [
                    'github' => $this->resume->github_url,
                    'linkedin' => $this->resume->linkedin_url,
                ],
                'about' => $this->resume->about,
                'tags' => $this->resume->tags->map(fn($tag) => [
                    'id' => $tag->id,
                    'tag_name' => $tag->tag_name,
                ])->toArray(),
            ]
        ]);
    }
}
