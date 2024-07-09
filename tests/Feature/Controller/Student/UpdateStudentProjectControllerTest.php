<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;
use App\Models\Company;
use App\Http\Controllers\api\Student\UpdateStudentProjectController;
use App\Service\Student\UpdateStudentProjectService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateStudentProjectControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $student;
    protected $project;
    protected $company;

    protected function setUp(): void
    {
        parent::setUp();
       
        $this->student = Student::factory()->create();
        $this->company = Company::factory()->create();
        $this->project = Project::factory()->create(['company_id' => $this->company->id]);     
        $this->student->resume()->create([
            'project_ids' => json_encode([$this->project->id])
        ]);
    }

    public function testControllerReturns200WithCorrectUuids(): void
    {
        $response = $this->put(route('student.updateproject', ['studentId' => $this->student->id, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'El projecte s\'ha actualitzat']);
    }

    public function testControllerReturns404WithIncorrectStudentUuid(): void
    {
        $invalidUuid = 'invalid_uuid';

        $response = $this->put(route('student.updateproject', ['studentId' => $invalidUuid, 'projectId' => $this->project->id]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertJson(['message' => 'No s\'ha trobat cap estudiant amb aquest ID: ' . $invalidUuid]);
        $response->assertStatus(404);
    }
    
    public function testControllerReturns404WithIncorrectProjectUuid(): void
    {
        $invalidUuid = 'invalid_uuid';

        $response = $this->put(route('student.updateproject', ['studentId' => $this->student->id, 'projectId' => $invalidUuid]), [
            'project_url' => 'https://new-project-url.com'
        ]);

        $response->assertJson(['message' => 'No s\'ha trobat cap projecte amb aquest ID: ' . $invalidUuid]);
        $response->assertStatus(404);
    }
    

    public function testControllerCanBeInstantiated(): void
    {
        $updateStudentProjectService = $this->createMock(UpdateStudentProjectService::class);

        $controller = new UpdateStudentProjectController($updateStudentProjectService);

        $this->assertInstanceOf(UpdateStudentProjectController::class, $controller);
    }
}
