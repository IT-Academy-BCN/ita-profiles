<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Project;
use App\Models\Company;
use App\Service\Student\UpdateStudentProjectService;
use Illuminate\Support\Facades\DB;
use Exception;

class UpdateStudentProjectServiceTest extends TestCase
{
    protected UpdateStudentProjectService $updateStudentProjectService;
    protected Student $student;
    protected Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateStudentProjectService = new UpdateStudentProjectService();

        $this->student = Student::factory()->create();
        $this->project = Project::factory()->create();
        $this->student->resume()->create([
            'project_ids' => json_encode([$this->project->id])
        ]);
    }

    public function testCanUpdateProjectSuccessfully(): void
    {
        $data = [
            'project_name' => 'Updated Project Name',
            'github_url' => 'https://github.com/updated-project',
            'project_url' => 'https://updated-project-url.com',
            'tags' => [1, 2],
            'company_name' => 'Updated Company'
        ];

        DB::beginTransaction();
        try {
            $this->updateStudentProjectService->execute($this->student->id, $this->project->id, $data);

            $updatedProject = $this->project->refresh();

            $this->assertEquals('Updated Project Name', $updatedProject->name);
            $this->assertEquals('https://github.com/updated-project', $updatedProject->github_url);
            $this->assertEquals('https://updated-project-url.com', $updatedProject->project_url);

            $expectedTagIds = [1, 2];
            $actualTagIds = json_decode($updatedProject->tags, true);
            sort($expectedTagIds);
            sort($actualTagIds);
            $this->assertEquals($expectedTagIds, $actualTagIds);

            $company = Company::find($updatedProject->company_id);
            $this->assertEquals('Updated Company', $company->name);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}
