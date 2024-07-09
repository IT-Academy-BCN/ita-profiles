<?php

declare(strict_types=1);

namespace Tests\Unit\Service\Student;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Student;
use App\Models\Company;
use App\Service\Student\UpdateStudentProjectService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateStudentProjectServiceTest extends TestCase
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
    }

    public function testCanUpdateStudentProjectByProjectId(): void
    {
        $service = new UpdateStudentProjectService();

        $data = [
            'name' => 'Project One',
            'tags' => ['tag1', 'tag2'],
            'github_url' => 'https://github.com/project1',
            'project_url' => 'https://project1.com',
            'company_name' => 'Company Name'
        ];

        $service->execute($this->student->id, $this->project->id, $data);
     
        $updatedProject = Project::find($this->project->id);

        $this->assertEquals('Project One', $updatedProject->name);

        $updatedTags = json_decode($updatedProject->tags, true);
        $this->assertEquals(['tag1', 'tag2'], $updatedTags);

        $this->assertEquals('https://github.com/project1', $updatedProject->github_url);
        $this->assertEquals('https://project1.com', $updatedProject->project_url);
       
        $updatedCompany = Company::find($this->company->id);
        $this->assertEquals('Company Name', $updatedCompany->name);
    }

    public function testCanThrowStudentNotFoundException(): void
    {
        $service = new UpdateStudentProjectService();

        $this->expectException(StudentNotFoundException::class);
        $service->execute('false_student_id', $this->project->id, []);
    }

    public function testCanThrowProjectNotFoundException(): void
    {
        $service = new UpdateStudentProjectService();

        $this->expectException(ProjectNotFoundException::class);
        $service->execute($this->student->id, 'false_project_id', []);
    }
}

