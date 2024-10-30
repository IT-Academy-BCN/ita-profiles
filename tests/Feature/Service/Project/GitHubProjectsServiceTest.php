<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Project;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Service\Project\GitHubProjectsService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Exception;

class GitHubProjectsServiceTest extends TestCase
{
    use DatabaseTransactions;
    private GitHubProjectsService $gitHubProjectsService;
    private Project $project;

    public function setUp(): void
    {
        parent::setUp();
        $this->gitHubProjectsService = new GitHubProjectsService();
        $this->project = Project::factory()->create();
    }

    /**
     * @throws Exception
     */
    public function testCanReturnGitHubUsername()
    {
        $resume = Resume::factory()->create(['github_url' => 'https://github.com/user1']);
        $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($resume);

        $this->assertEquals('user1', $gitHubUsername);
        $this->assertIsString($gitHubUsername);
    }

    public function testCanThrowExceptionForInvalidGitHubUrl()
    {
        $resume = Resume::factory()->create(['github_url' => 'https://notgithub.com/user2']);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid GitHub URL: https://notgithub.com/user2");

        $this->gitHubProjectsService->getGitHubUsername($resume);
    }

    /**
     * @throws Exception
     */
    public function testCanReturnGitHubUsernameWithTrailingSlash()
    {
        $resume = Resume::factory()->create(['github_url' => 'https://github.com/user1/']);
        $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($resume);

        $this->assertEquals('user1', $gitHubUsername);
        $this->assertIsString($gitHubUsername);
    }

    /**
     * @throws Exception
     */
    public function testCanFetchGitHubReposSuccessfully()
    {
        $gitHubUsername = "username";
        $expectedResponse = $this->mockGitHubReposResponse($gitHubUsername);
        Http::fake([
            "https://api.github.com/users/$gitHubUsername/repos" => Http::response($expectedResponse),
        ]);

        $repos = $this->gitHubProjectsService->fetchGitHubRepos($gitHubUsername);

        $this->assertIsArray($repos);
        $this->assertCount(2, $repos);
        $this->assertEquals($expectedResponse, $repos);
    }

    public function testCanFetchGitHubReposThrowsExceptionOnRequestError()
    {
        $username = "username";

        Http::fake([
            "https://api.github.com/users/$username/repos" => Http::response(null, 404)
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error fetching GitHub repositories for: $username. Status code: 404");

        $this->gitHubProjectsService->fetchGitHubRepos($username);
    }

    /**
     * @throws Exception
     */
    public function testCanFetchRepoLanguagesSuccessfully()
    {
        $languagesUrl = "https://api.github.com/repos/username/repo/languages";
        $expectedLanguages = [
            'PHP' => 5000,
            'JavaScript' => 3000,
        ];

        Http::fake([
            $languagesUrl => Http::response($expectedLanguages)
        ]);

        $languages = $this->gitHubProjectsService->fetchRepoLanguages($languagesUrl);

        $this->assertIsArray($languages);
        $this->assertEquals($expectedLanguages, $languages);
    }

    public function testCanFetchRepoLanguagesThrowsExceptionOnRequestError()
    {
        $languagesUrl = "https://api.github.com/repos/username/repo/languages";

        Http::fake([
            $languagesUrl => Http::response(null, 404)
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error fetching GitHub repository languages for: $languagesUrl. Status code: 404");

        $this->gitHubProjectsService->fetchRepoLanguages($languagesUrl);
    }

    /**
     * @throws Exception
     */
    public function testCanSaveRepositoriesAsProjectsSuccessfully()
    {
        $repos = $this->mockGitHubReposResponse("username");
        $tags = Tag::limit(2)->pluck('name')->toArray();
        $languages = array_fill_keys($tags, 5000);


        Http::fake([
            'https://api.github.com/repos/username/repo1/languages' => Http::response($languages),
            'https://api.github.com/repos/username/repo2/languages' => Http::response($languages),
        ]);

        $projects = $this->gitHubProjectsService->saveRepositoriesAsProjects($repos);

        $this->assertCount(2, $projects);
        foreach ($projects as $project) {
            $this->assertDatabaseHas('projects', [
                'github_repository_id' => $project->github_repository_id,
                'name' => $project->name,
                'github_url' => $project->github_url,
            ]);

            $expectedTags = Tag::whereIn('name', $tags)->pluck('id')->toArray();
            $this->assertEqualsCanonicalizing($expectedTags, $project->tags()->pluck('tag_id')->toArray());
        }
    }

    public function testSaveRepositoriesAsProjectsThrowsException()
    {
        $repos = [$this->mockGitHubReposResponse("username")[0]];

        Http::fake([
            $repos[0]['languages_url'] => Http::response(null, 404),
        ]);

        $this->expectException(Exception::class);
        $this->gitHubProjectsService->saveRepositoriesAsProjects($repos);
    }

    private function mockGitHubReposResponse(string $gitHubUsername): array
    {
        return [
            [
                'id' => 1,
                'name' => 'repo1',
                'languages_url' => "https://api.github.com/repos/$gitHubUsername/repo1/languages",
                'owner' => ['login' => $gitHubUsername],
                'html_url' => "https://github.com/$gitHubUsername/repo1",
            ],
            [
                'id' => 2,
                'name' => 'repo2',
                'languages_url' => "https://api.github.com/repos/$gitHubUsername/repo2/languages",
                'owner' => ['login' => $gitHubUsername],
                'html_url' => "https://github.com/$gitHubUsername/repo2",
            ],
        ];
    }
}
