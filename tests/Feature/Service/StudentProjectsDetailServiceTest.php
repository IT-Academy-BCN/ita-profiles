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
use App\Exceptions\ResumeNotFoundException;
use App\Models\Student;

class StudentProjectsDetailServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $studentProjectsDetailService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentProjectsDetailService = new StudentProjectsDetailService();
    }

    public function test_execute_returns_projects_for_valid_student():void
    {
        $student = Students::aStudent();

        $resume = Resumes::createResumeWithModality($student->id, 'frontend', ['tag1', 'tag2'], 'Presencial');

        $projectNames = ['Project 1', 'Project 2', 'Project 3'];

        ProjectsForResume::createProjectsForResume($resume->id, $projectNames);

        $response = $this->studentProjectsDetailService->execute($student->id);

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

    public function test_execute_throws_exception_for_nonexistent_student_UUID():void
    {
        $this->expectException(StudentNotFoundException::class);

        $this->studentProjectsDetailService->execute('nonExistentStudentId');
    }

    public function test_execute_throws_exception_for_student_without_resume():void
    {
        $student = Students::aStudent();

        $this->expectException(ResumeNotFoundException::class);

        $this->studentProjectsDetailService->execute($student->id);
    }

    public function testProjectsServiceReturnsEmptyArrayWhenNoProjectsFound(): void
    {
        $student = Student::factory()->create();

        Resumes::createResumeWithEmptyProjects($student->id);

        $service = new StudentProjectsDetailService();

        $projects = $service->execute($student->id);

        $this->assertIsArray($projects);
        
        $this->assertEmpty($projects);
    }

    public function testStudentProjectsDetailServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentProjectsDetailService::class, $this->studentProjectsDetailService);
    }
}
