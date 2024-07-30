<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;
use App\Models\Company;
use App\Models\User;
use App\Service\Student\UpdateStudentProjectService;
use App\Service\Student\StudentService;
use App\Http\Controllers\api\Student\UpdateStudentProjectController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Mockery;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;
use Illuminate\Auth\Access\Response;

class UpdateStudentProjectControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected Student $student;
    protected Project $project;
    protected Company $company;
    protected User $user;

    protected const INVALID_UUID = 'invalid_uuid';

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();
        $this->project = Project::factory()->create();
        $this->student->resume()->create([
            'project_ids' => json_encode([$this->project->id])
        ]);

        // Create user and assign it to the student
        $this->user = User::factory()->create();
        $this->student->user_id = $this->user->id;
        $this->student->save();

        // Authenticate user using Passport
        Passport::actingAs($this->user, ['check-status']);
    }

    public function testControllerReturns200WithCorrectUuids(): void
    {
        $response = $this->json('PUT', route('student.updateProject', ['studentId' => $this->student->id, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'El projecte s\'ha actualitzat']);
    }

    public function testControllerReturns407WithIncorrectStudentUuid(): void
    {
        $response = $this->json('PUT', route('student.updateProject', ['studentId' => self::INVALID_UUID, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertJson(['error' => 'URL Error']);
        $response->assertStatus(407);
    }

    public function testControllerReturns404WithIncorrectProjectUuid(): void
    {
        $response = $this->json('PUT', route('student.updateProject', ['studentId' => $this->student->id, 'projectId' => self::INVALID_UUID]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertJson(['message' => 'No s\'ha trobat cap projecte amb aquest ID: ' . self::INVALID_UUID]);
        $response->assertStatus(404);
    }

    public function testControllerReturns403ForProjectBelongingToAnotherStudent(): void
    {
        $anotherStudent = Student::factory()->create();
        $anotherProject = Project::factory()->create();
        $anotherStudent->resume()->create([
            'project_ids' => json_encode([$anotherProject->id])
        ]);

        // Attempt to update another student's project
        $response = $this->json('PUT', route('student.updateProject', ['studentId' => $this->student->id, 'projectId' => $anotherProject->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(403);
        $response->assertJson(['error' => 'Unauthorized']);
    }

    public function testControllerReturns404ForNonExistentStudent(): void
    {        
         //Mockering middleware
         $ensureStudentMiddleware = Mockery::mock('App\Http\Middleware\EnsureStudentOwner[handle]');
         $ensureStudentMiddleware->shouldReceive('handle')->once()
             ->andReturnUsing(function ($request, \Closure $next) {
                 return $next($request);
             });
         $this->app->instance('App\Http\Middleware\EnsureStudentOwner', $ensureStudentMiddleware);
 
         //Mockering Policy
         $userPolicyMockery = Mockery::mock('App\Policies\UserPolicy');
         $userPolicyMockery->shouldReceive('canAccessResource')->once()
             ->andReturn(Response::allow());
         $this->app->instance('App\Policies\UserPolicy', $userPolicyMockery);
        
        $response = $this->json('PUT', route('student.updateProject', ['studentId' => self::INVALID_UUID, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => sprintf(StudentNotFoundException::MESSAGE, self::INVALID_UUID)]);
    }
    public function testControllerCanBeInstantiated(): void
    {
        $updateStudentProjectService = Mockery::mock(UpdateStudentProjectService::class);
        $studentService = Mockery::mock(StudentService::class);

        $controller = new UpdateStudentProjectController($updateStudentProjectService, $studentService);

        $this->assertInstanceOf(UpdateStudentProjectController::class, $controller);
    }

    public function testMiddlewareAllowsAccessToSelfUser(): void
    {
        $response = $this->put(route('student.updateProject', ['studentId' => $this->student->id, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(200);
    }

    public function testMiddlewareDeniesAccessToAnotherUser(): void
    {
        $anotherUser = User::factory()->create();
        Passport::actingAs($anotherUser, ['check-status']);

        $response = $this->put(route('student.updateProject', ['studentId' => $this->student->id, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(403);
    }
}
