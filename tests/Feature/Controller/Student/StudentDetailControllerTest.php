<?php

namespace Tests\Feature\Controller\Student;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Tag;

class StudentDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $tags = Tag::all()->take(3);
        $this->student = Student::factory()->create();
        $this->student->tags()->attach($tags->pluck('id'));
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
            'status' => $this->student->status->value,
            'tags' => $this->student->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ];
            })->toArray(),
            'resume' => [
                'subtitle' => $this->resume->subtitle,
                'social_media' => [
                    'github' => $this->resume->github_url,
                    'linkedin' => $this->resume->linkedin_url,
                ],
                'about' => $this->resume->about,
            ]
        ]);
    }
}
