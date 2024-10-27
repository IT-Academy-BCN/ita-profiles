<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Project;

use App\Models\Resume;
use App\Service\Project\GitHubProjectsService;
use App\Service\Project\ProjectProcessingService;
use App\Service\Resume\ResumeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class ProjectProcessingServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $gitHubProjectsService;
    protected $resumeService;
    protected $projectProcessingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gitHubProjectsService = Mockery::mock(GitHubProjectsService::class);
        $this->resumeService = Mockery::mock(ResumeService::class);

        $this->projectProcessingService = new ProjectProcessingService(
            $this->gitHubProjectsService,
            $this->resumeService
        );
    }

    protected function mockResumeData(string $username): Resume
    {
        return Resume::factory()->create(['github_url' => 'https://github.com/' . $username]);
    }

    protected function mockGitHubServices(Resume $resume, string $username, array $repos, array $projects)
    {
        $this->gitHubProjectsService->shouldReceive('getGitHubUsername')
            ->with($resume)
            ->andReturn($username);

        $this->gitHubProjectsService->shouldReceive('fetchGitHubRepos')
            ->with($username)
            ->andReturn($repos);

        $this->gitHubProjectsService->shouldReceive('saveRepositoriesAsProjects')
            ->with($repos)
            ->andReturn($projects);

        $this->resumeService->shouldReceive('saveProjectsInResume')
            ->with($projects, $resume)
            ->andReturnTrue();
    }

    public function testCanProcessSingleResumeSuccessfully()
    {
        $username = 'testuser';
        $resume = $this->mockResumeData($username);
        $repos = $this->getMockedRepos();
        $projects = $this->getMockedProjects();

        $this->mockGitHubServices($resume, $username, $repos, $projects);

        Log::shouldReceive('info')->times(3);

        $this->projectProcessingService->processSingleResume($resume);

        $this->assertTrue(true);
    }

    public function testCanProcessAllResumesSuccessfully()
    {
        $resumes = collect(['testuser1', 'testuser2'])->map(fn($user) => $this->mockResumeData($user));
        $repos = $this->getMockedRepos();
        $projects = $this->getMockedProjects();

        $this->resumeService->shouldReceive('getResumes')->andReturn(new Collection($resumes));

        foreach ($resumes as $resume) {
            $this->mockGitHubServices($resume, $resume->github_url, $repos, $projects);
        }

        Log::shouldReceive('info')->times(6); // Expecting 6 log entries (3 per resume)

        $this->projectProcessingService->processAllResumes();

        $this->assertTrue(true);
    }

    public function testCanLogErrorWhenProcessingFails()
    {
        $username = 'testuser';
        $resume = $this->mockResumeData($username);

        $this->gitHubProjectsService->shouldReceive('getGitHubUsername')
            ->with($resume)
            ->andReturn($username);

        $this->gitHubProjectsService->shouldReceive('fetchGitHubRepos')
            ->with($username)
            ->andThrow(new \Exception("Error fetching GitHub repositories"));

        Log::shouldReceive('error')
            ->once()
            ->withArgs(fn($message) => str_contains($message, "Error processing GitHub projects"));

        $this->projectProcessingService->processSingleResume($resume);
    }
    private function getMockedRepos(): array
    {
        return [
            ['id' => 1, 'name' => 'Repo 1'],
            ['id' => 2, 'name' => 'Repo 2'],
        ];
    }

    private function getMockedProjects(): array
    {
        return [
            ['id' => 1, 'name' => 'Project 1'],
            ['id' => 2, 'name' => 'Project 2'],
        ];
    }
}
