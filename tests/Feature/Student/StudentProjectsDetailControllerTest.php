<?php

declare(strict_types=1);

namespace Tests\Feature\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;
use Tests\Fixtures\Students;
use App\Models\Resume;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class StudentProjectsDetailControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $student;
    protected $projects;

    public function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();

        $this->projects = Project::factory()->count(3)->create();
        $this->student->resume()->create([
            'project_ids' => json_encode($this->projects->pluck('id')->toArray())
        ]);
    }

    public function test_controller_returns_correct_response_with_valid_uuid()
    {
        $response = $this->get(route('student.projects', ['studentId' => $this->student->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'projects' => [
                    '*' => [
                        'uuid',
                        'project_name',
                        'company_name',
                        'project_url',
                        'tags',
                        'github_url'
                    ]
                ]
            ]);
    }

    public function test_controller_returns_404_with_invalid_uuid()
    {
        $invalidUuid = 'invalid_uuid';

        $response = $this->get(route('student.projects', ['studentId' => $invalidUuid]));

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: ' . $invalidUuid]);

        $response->assertStatus(404);
    }

    public function test_controller_returns_404_with_no_resume()
    {
        $student = Students::aStudent();

        Resume::where('student_id', $student->id)->delete();

        $response = $this->get(route('student.projects', ['studentId' => $student->id]));

        $response->assertJson(['message' => 'No s\'ha trobat cap currículum per a l\'estudiant amb id: ' . $student->id]);
        $response->assertStatus(404);
    }
}
