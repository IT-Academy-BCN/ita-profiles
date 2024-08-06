<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Project;

use App\Models\Project;
use App\Models\Resume;
use Tests\TestCase;
use App\Service\Project\GitHubProjectsService;
use App\Service\Resume\ResumeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GitHubProjectsServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $gitHubProjectsService;
    private $resumeService;
    private $project;

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeService = new ResumeService();
        $this->gitHubProjectsService = new GitHubProjectsService($this->resumeService);

        // Create the project once and reuse it in all tests
        $this->project = Project::factory()->create();
    }

    public function testItReturnsGitHubUsername()
    {
        $resume = Resume::factory()->create([
            'github_url' => 'https://github.com/user1',
            'project_ids' => json_encode([$this->project->id]),
        ]);

        $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($this->project);

        $this->assertEquals('user1', $gitHubUsername);
        $this->assertIsString($gitHubUsername);
    }

    public function testItThrowsExceptionForInvalidGitHubUrl()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid GitHub URL: https://notgithub.com/user2");

        $resume = Resume::factory()->create([
            'github_url' => 'https://notgithub.com/user2',
            'project_ids' => json_encode([$this->project->id]),
        ]);

        $this->gitHubProjectsService->getGitHubUsername($this->project);
    }

    public function testItThrowsExceptionForNullGitHubUrl()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("GutHub url not found");

        $resume = Resume::factory()->create([
            'github_url' => null,
            'project_ids' => json_encode([$this->project->id]),
        ]);

        $this->gitHubProjectsService->getGitHubUsername($this->project);
    }
}
