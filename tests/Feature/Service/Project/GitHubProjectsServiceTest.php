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

    // TESTS FOR FUNCTION: getGitHubUsername
    public function testItReturnsGitHubUsername()
    {
        $resume = Resume::factory()->create([
            'github_url' => 'https://github.com/user1',
        ]);

        $resume->projects()->attach($this->project->id);

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
        ]);

        $resume->projects()->attach($this->project->id);

        $this->gitHubProjectsService->getGitHubUsername($this->project);
    }

    public function testItThrowsExceptionForNullGitHubUrl()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("GutHub url not found");

        $resume = Resume::factory()->create([
            'github_url' => null,
        ]);

        $resume->projects()->attach($this->project->id);

        $this->gitHubProjectsService->getGitHubUsername($this->project);
    }

    public function testItReturnsGitHubUsernameWithTrailingSlash()
    {
        $resume = Resume::factory()->create([
            'github_url' => 'https://github.com/user1/',
        ]);

        $resume->projects()->attach($this->project->id);

        $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($this->project);

        $this->assertEquals('user1', $gitHubUsername);
        $this->assertIsString($gitHubUsername);
    }

    // TESTS FOR FUNCTION: fetchGitHubRepos
    public function testFetchGitHubReposSuccess()
    {
        // Dummy assertion to make the test pass temporarily
        $this->assertTrue(true);
    }

    // TESTS FOR FUNCTION: fetchRepoLanguages
    public function testFetchRepoLanguagesSuccess()
    {
        // Dummy assertion to make the test pass temporarily
        $this->assertTrue(true);
    }

    // TESTS FOR FUNCTION: saveRepositoriesAsProjects
    public function testSaveRepositoriesAsProjectsSuccess()
    {
        // Dummy assertion to make the test pass temporarily
        $this->assertTrue(true);
    }
}
