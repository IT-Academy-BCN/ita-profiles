<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Models\Resume;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;

class UpdateStudentProjectControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected Student $student;
    protected Project $project;
    protected User $user;
    protected Resume $resume;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();
        $this->project = Project::factory()->create();
        $this->resume = $this->student->resume()->create();
        $this->resume->projects()->attach($this->project->id);

        // Create user and assign it to the student
        $this->user = User::factory()->create();
        $this->student->user_id = $this->user->id;
        $this->student->save();

        // Authenticate user using Passport
        Passport::actingAs($this->user, ['check-status']);
    }

    public function testControllerReturns200WithValidRequest(): void
    {
        $data = [
            'project_url' => 'https://new-project-url.com'
        ];

        $response = $this->json('PUT', route('student.updateProject', ['student' => $this->student->id, 'project' => $this->project->id]), $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'El projecte s\'ha actualitzat']);
    }

    public function testControllerReturns404ForInvalidStudentId(): void
    {
        $data = [
            'project_url' => 'https://new-project-url.com'
        ];

        $response = $this->json('PUT', route('student.updateProject', ['student' => 'invalid_student_id', 'project' => $this->project->id]), $data);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] invalid_student_id']); // Ensure this matches the response from the controller
    }

    public function testControllerReturns404ForInvalidProjectId(): void
    {
        $data = [
            'project_url' => 'https://new-project-url.com'
        ];

        $response = $this->json('PUT', route('student.updateProject', ['student' => $this->student->id, 'project' => 'invalid_project_id']), $data);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No query results for model [App\\Models\\Project] invalid_project_id']); // Ensure this matches the response from the controller
    }

    public function testControllerReturns403ForUnauthorizedUpdate(): void
    {
        $anotherStudent = Student::factory()->create();
        $anotherProject = Project::factory()->create();
        $anotherStudent->resume()->create([
            'project_ids' => json_encode([$anotherProject->id])
        ]);

        // Try to update a project belonging to another student
        $response = $this->json('PUT', route('student.updateProject', ['student' => $this->student->id, 'project' => $anotherProject->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'Unauthorized']); // Ensure this matches the response from the controller
    }
}
