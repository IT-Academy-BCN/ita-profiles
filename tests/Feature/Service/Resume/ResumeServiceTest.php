<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Resume;

use App\Models\Project;
use App\Models\Resume;
use Tests\TestCase;
use App\Service\Resume\ResumeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResumeServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $resumeService;
    private $project;
    private $project2;
    private $project3;
    private $resume;

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeService = new ResumeService();
        // For some reason, if I don't delete the resumes here, the test fails because finds other Resumes...
        Resume::query()->delete();
        // Create the projects once and reuse them for all tests
        $this->project = Project::factory()->create();
        $this->project2 = Project::factory()->create();
        $this->project3 = Project::factory()->create();

        // Crea el resume
        $this->resume = Resume::factory()->create([
            'github_url' => 'https://github.com/user1',
        ]);

        // Asocia los proyectos a este resume utilizando la relación many-to-many
        $this->resume->projects()->attach([$this->project->id]);
    }

    public function testItGetsResumeByGitHubUsername()
    {
        $foundResume = $this->resumeService->getResumeByGitHubUsername('user1');

        $this->assertEquals($this->resume->id, $foundResume->id);
    }

    public function testItThrowsExceptionWhenResumeIsNull()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Resume not found for GitHub username: user2");

        $this->resumeService->getResumeByGitHubUsername('user2');
    }

    public function testSaveProjectsInResumeSuccessfully()
    {
        // Define new projects to be added
        $projectsToAdd = [$this->project2, $this->project3];

        // Call the method to save projects in resume
        $this->resumeService->saveProjects($projectsToAdd, 'user1');

        // Fetch the updated resume
        $updatedResume = Resume::find($this->resume->id);

        $projectIds = $updatedResume->projects->pluck('id')->toArray();

        // Check if the projects were added
        $this->assertContains($this->project->id, $projectIds);
        $this->assertContains($this->project2->id, $projectIds);
        $this->assertContains($this->project3->id, $projectIds);
    }

    public function testSaveProjectsInResumeThrowsExceptionWhenResumeNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error saving projects in Resume: Error retrieving resume by GitHub username: Resume not found for GitHub username: user2");
        // Define new projects to be added
        $projectsToAdd = [$this->project2, $this->project3];

        // Call the method with a non-existing GitHub username
        $this->resumeService->saveProjects($projectsToAdd, 'user2');
    }
}
