<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;
use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\api\Student\StudentProjectsDetailController;

class StudentProjectsDetailControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $projects;

    protected function setUp(): void
    {
        parent::setUp();
        $this->student = Student::factory()->create();
        $this->projects = Project::factory()->count(3)->create();
        $resume = $this->student->resume()->create();
        $resume->projects()->attach($this->projects->pluck('id')->toArray());
    }

    public function testStudentProjectsDetailControllerCanBeInstantiated(): void
    {
        $controller = new StudentProjectsDetailController();

        $this->assertInstanceOf(StudentProjectsDetailController::class, $controller);
    }

    public function testStudentProjectsDetailsAreFound(): void
    {
        $response = $this->get(route('student.projects', ['student' => $this->student]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'projects' => [
                '*' => [
                    'id',
                    'name',
                    'github_url',
                    'project_url',
                    'company_name',
                    'tags' => [
                        '*' => [
                            'id',
                            'name'
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function testStudentProjectsDetailControllerReturns404WhenStudentNotFound(): void
    {
        $invalidUuid = 'invalid_uuid';

        $response = $this->get(route('student.projects', ['student' => $invalidUuid]));
        
        $response->assertStatus(404);
        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] ' . $invalidUuid]);
    }

    public function testStudentProjectsDetailControllerReturnsEmptyProjectsWhenNoResume(): void
    {
        Resume::where('student_id', $this->student->id)->delete();

        $response = $this->get(route('student.projects', ['student' => $this->student->id]));

        $response->assertStatus(200);
        $response->assertJson(['projects' => []]);
    }

    public function testStudentProjectsDetailControllerReturnsEmptyProjectsWhenNoProjects(): void
    {
        $resume = $this->student->resume;
        $resume->projects()->detach();

        $response = $this->get(route('student.projects', ['student' => $this->student->id]));

        $response->assertStatus(200);
        $response->assertJson(['projects' => []]);
    }
}
