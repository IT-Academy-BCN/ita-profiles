<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Project;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Mockery;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
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
        $this->clientMock = Mockery::mock(Client::class);
        $this->gitHubProjectsService = new GitHubProjectsService($this->clientMock);
        $this->project = Project::factory()->create();
    }

    private function mockClientException(string $url, int $statusCode = 404): void
    {
        $this->clientMock
            ->shouldReceive('get')
            ->once()
            ->with($url, Mockery::any())
            ->andThrow(new RequestException("Error Communicating with GitHub", new Request('GET', 'test'), new Response($statusCode)));
    }

    private function mockResponseWithBody(string $body): ResponseInterface
    {
        $responseMock = Mockery::mock(ResponseInterface::class);
        $responseMock->shouldReceive('getBody->getContents')->andReturn($body);
        return $responseMock;
    }

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

    public function testCanReturnGitHubUsernameWithTrailingSlash()
    {
        $resume = Resume::factory()->create(['github_url' => 'https://github.com/user1/']);
        $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($resume);

        $this->assertEquals('user1', $gitHubUsername);
        $this->assertIsString($gitHubUsername);
    }

    public function testCanFetchGitHubReposSuccessfully()
    {
        $username = "username";
        $expectedResponse = $this->mockGitHubReposResponse($username);

        $this->clientMock
            ->shouldReceive('get')
            ->once()
            ->with("https://api.github.com/users/$username/repos", Mockery::any())
            ->andReturn(new Response(200, [], json_encode($expectedResponse)));

        $repos = $this->gitHubProjectsService->fetchGitHubRepos($username);

        $this->assertIsArray($repos);
        $this->assertCount(2, $repos);
        $this->assertEquals($expectedResponse, $repos);
    }

    public function testCanFetchGitHubReposThrowsExceptionOnRequestError()
    {
        $username = "username";

        $this->mockClientException("https://api.github.com/users/$username/repos");

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error fetching GitHub repositories for: $username. Status code: 404");

        $this->gitHubProjectsService->fetchGitHubRepos($username);
    }

    public function testCanFetchRepoLanguagesSuccessfully()
    {
        $languagesUrl = "https://api.github.com/repos/username/repo/languages";
        $expectedLanguages = [
            'PHP' => 5000,
            'JavaScript' => 3000,
        ];

        $this->clientMock
            ->shouldReceive('get')
            ->once()
            ->with($languagesUrl, Mockery::any())
            ->andReturn(new Response(200, [], json_encode($expectedLanguages)));

        $languages = $this->gitHubProjectsService->fetchRepoLanguages($languagesUrl);

        $this->assertIsArray($languages);
        $this->assertEquals($expectedLanguages, $languages);
    }

    public function testCanFetchRepoLanguagesThrowsExceptionOnRequestError()
    {
        $languagesUrl = "https://api.github.com/repos/username/repo/languages";

        $this->mockClientException($languagesUrl, 404);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error fetching GitHub repository languages for: $languagesUrl. Status code: 404");

        $this->gitHubProjectsService->fetchRepoLanguages($languagesUrl);
    }

    public function testCanSaveRepositoriesAsProjectsSuccessfully()
    {
        $repos = $this->mockGitHubReposResponse("username");
        $tags = Tag::limit(2)->pluck('name')->toArray();
        $languages = array_fill_keys($tags, 5000);

        $this->clientMock
            ->shouldReceive('get')
            ->twice()
            ->andReturnUsing(fn() => $this->mockResponseWithBody(json_encode($languages)));

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
        $this->mockClientException($repos[0]['languages_url']);

        $this->expectException(Exception::class);
        $this->gitHubProjectsService->saveRepositoriesAsProjects($repos);
    }

    private function mockGitHubReposResponse(string $username): array
    {
        return [
            [
                'id' => 1,
                'name' => 'repo1',
                'languages_url' => "https://api.github.com/repos/$username/repo1/languages",
                'owner' => ['login' => $username],
                'html_url' => "https://github.com/$username/repo1",
            ],
            [
                'id' => 2,
                'name' => 'repo2',
                'languages_url' => "https://api.github.com/repos/$username/repo2/languages",
                'owner' => ['login' => $username],
                'html_url' => "https://github.com/$username/repo2",
            ]
        ];
    }
}
