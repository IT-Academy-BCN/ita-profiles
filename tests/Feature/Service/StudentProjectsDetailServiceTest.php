<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Fixtures\Students;
use Tests\Fixtures\Resumes;
use Tests\Fixtures\ProjectsForResume;
use App\Service\Student\StudentProjectsDetailService;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;
use App\Exceptions\ResumeNotFoundException;


class StudentProjectsDetailServiceTest extends TestCase
{
    use DatabaseTransactions;
    protected $projectsService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectsService = new StudentProjectsDetailService();
    }
    public function test_execute_returns_projects_for_valid_student()
    {
        $student = Students::aStudent();
        $resume = Resumes::createResumeWithModality($student->id, 'frontend', ['tag1', 'tag2'], 'Presencial');


        $projectNames = ['Project 1', 'Project 2', 'Project 3'];
        ProjectsForResume::createProjectsForResume($resume->id, $projectNames);

        $response = $this->projectsService->execute($student->id);

        $this->assertIsArray($response);
        $this->assertCount(3, $response);

        foreach ($response as $projectDetail) {
            $this->assertArrayHasKey('uuid', $projectDetail);
            $this->assertArrayHasKey('project_name', $projectDetail);
            $this->assertArrayHasKey('company_name', $projectDetail);
            $this->assertArrayHasKey('project_url', $projectDetail);
            $this->assertArrayHasKey('tags', $projectDetail);
            $this->assertArrayHasKey('github_url', $projectDetail);
        }
    }
    public function test_execute_throws_exception_for_nonexistent_student_UUID()
    {
        $this->expectException(StudentNotFoundException::class);
        $this->projectsService->execute('nonExistentStudentId');
    }
    public function test_execute_throws_exception_for_student_without_resume()
{
    // Crear un estudiante sin currículum
    $student = Students::aStudent();

    $this->expectException(ResumeNotFoundException::class);
    $this->projectsService->execute($student->id);
}
public function test_execute_throws_exception_for_student_with_empty_projects()
{
    // Crear un estudiante
    $student = Students::aStudent();

    // Crear un currículum sin proyectos para el estudiante
    Resumes::createResumeWithEmptyProjects($student->id);

    $this->expectException(ProjectNotFoundException::class);
    $this->projectsService->execute($student->id);
}


}
