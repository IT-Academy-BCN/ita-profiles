<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use App\Http\Controllers\api\Student\UpdateStudentProjectController;
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

        $this->user = User::factory()->create();
        $this->student->user_id = $this->user->id;
        $this->student->save();

        Passport::actingAs($this->user);
    }

    public function testCanInstantiateController(): void
    {
        $controller = new UpdateStudentProjectController();

        $this->assertInstanceOf(UpdateStudentProjectController::class, $controller);
    }

    public function testCanReturn200WithValidRequest(): void
    {
        $data = [
            'project_url' => 'https://new-project-url.com'
        ];

        $response = $this->json('PUT', route('student.updateProject', ['student' => $this->student->id, 'project' => $this->project->id]), $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'El projecte s\'ha actualitzat']);
    }

    public function testCanReturn404ForInvalidStudentId(): void
    {
        $data = [
            'project_url' => 'https://new-project-url.com'
        ];

        $response = $this->json('PUT', route('student.updateProject', ['student' => 'invalid_student_id', 'project' => $this->project->id]), $data);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No query results for model [App\\Models\\Student] invalid_student_id']);
    }

    public function testCanReturn404ForInvalidProjectId(): void
    {
        $data = [
            'project_url' => 'https://new-project-url.com'
        ];

        $response = $this->json('PUT', route('student.updateProject', ['student' => $this->student->id, 'project' => 'invalid_project_id']), $data);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'No query results for model [App\\Models\\Project] invalid_project_id']);
    }

    public function testCanReturn403ForUnauthorizedUpdate(): void
    {
        $anotherStudent = Student::factory()->create();
        $anotherProject = Project::factory()->create();

        $resume = Resume::factory()->create([
            'student_id' => $anotherStudent->id,
            'github_url' => 'https://github.com/user1',
        ]);
        $resume->projects()->attach($anotherProject->id);

        $response = $this->json('PUT', route('student.updateProject', ['student' => $this->student->id, 'project' => $anotherProject->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'This action is unauthorized.']);
    }
}
