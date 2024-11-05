<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\Http;

class GitHubProjectsService
{
    protected ?string $githubToken;

    public function __construct()
    {
        $this->githubToken = config('github.token');
    }

    /**
     * @throws Exception
     */
    public function getGitHubUsername(Resume $resume): string
    {
        $github_url = $resume->github_url;
        $parsedUrl = parse_url($github_url);
        if ($parsedUrl['host'] !== 'github.com' || empty($parsedUrl['path'])) {
            throw new Exception("Invalid GitHub URL: " . $github_url);
        }

        return trim($parsedUrl['path'], '/');
    }

    /**
     * @throws Exception
     */
    public function fetchGitHubRepos(string $gitHubUsername): array
    {
        $headers = $this->prepareHeaders();

        $response = Http::withHeaders($headers)
            ->get("https://api.github.com/users/$gitHubUsername/repos");

        if ($response->successful()) {
            return $response->json();
        } else {
            $statusCode = $response->status();
            throw new Exception("Error fetching GitHub repositories for: $gitHubUsername. Status code: $statusCode\n");
        }
    }

    /**
     * @throws Exception
     */
    public function fetchRepoLanguages(string $languagesUrl): array
    {
        $headers = $this->prepareHeaders();

        $response = Http::withHeaders($headers)->get($languagesUrl);

        if ($response->successful()) {
            return $response->json();
        } else {
            $statusCode = $response->status();
            throw new Exception("Error fetching GitHub repository languages for: $languagesUrl. Status code: $statusCode\n");
        }
    }

    /**
     * @throws Exception
     */
    public function saveRepositoriesAsProjects(array $repos): array
    {
        $projects = [];
        $allTags = Tag::pluck('id', 'name')->toArray();

        foreach ($repos as $repo) {
            $languages = $this->fetchRepoLanguages($repo['languages_url']);
            $languageNames = array_keys($languages);
            $tagIds = array_intersect_key($allTags, array_flip($languageNames));

            $project = Project::updateOrCreate(
                ['github_repository_id' => $repo['id']],
                [
                    'user' => $repo['owner']['login'],
                    'name' => $repo['name'],
                    'github_url' => $repo['html_url'],
                ]
            );
            $project->tags()->sync($tagIds);

            $projects[] = $project;
        }

        return $projects;
    }

    private function prepareHeaders(): array
    {
        $headers = [
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'LaravelApp',
        ];

        if ($this->githubToken) {
            $headers['Authorization'] = "Bearer $this->githubToken";
        }

        return $headers;
    }
}
