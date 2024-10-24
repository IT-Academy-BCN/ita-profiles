<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GitHubProjectsService
{
    protected mixed $githubToken;
    private Client $client;

    public function __construct(Client $client = null)
    {
        $this->githubToken = config('github.token');
        $this->client = $client ?? new Client;
    }

    /**
     * @throws Exception
     */
    public function getGitHubUsername(Resume $resume): string
    {
        try {
            $parsedUrl = parse_url($resume->github_url);
            if ($parsedUrl['host'] !== 'github.com' || empty($parsedUrl['path'])) {
                throw new Exception("Invalid GitHub URL: " . $resume->github_url);
            }

            return trim($parsedUrl['path'], '/');

        } catch (Exception $e) {
            throw new Exception("Error processing GitHub username: " . $e->getMessage());
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchGitHubRepos(string $gitHubUsername): array
    {
        try {
            $headers = [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'LaravelApp',
            ];

            if ($this->githubToken) {
                $headers['Authorization'] = "Bearer $this->githubToken";
            }

            $response = $this->client->get("https://api.github.com/users/$gitHubUsername/repos", [
                'headers' => $headers,
                'synchronous' => true
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception) {
            throw new Exception("Error fetching GitHub repositories for: " . $gitHubUsername);
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchRepoLanguages(string $languagesUrl): array
    {
        try {
            $headers = [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'LaravelApp',
            ];

            if ($this->githubToken) {
                $headers['Authorization'] = "Bearer $this->githubToken";
            }

            $response = $this->client->get($languagesUrl, [
                'headers' => $headers,
                'synchronous' => true
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception("Error fetching GitHub repository languages: " . $e->getMessage());
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function saveRepositoriesAsProjects(array $repos): array
    {
        try {
            $projects = [];
            $allTags = Tag::all();

            foreach ($repos as $repo) {
                $languages = $this->fetchRepoLanguages($repo['languages_url']);
                $languageNames = array_keys($languages);
                $tagIds = $allTags->whereIn('name', $languageNames)->pluck('id')->toArray();
                $project = Project::updateOrCreate(
                    ['github_repository_id' => $repo['id']],
                    [
                        'user' => $repo['owner']['login'],
                        'name' => $repo['name'],
                        'github_url' => $repo['html_url'],
                        'github_repository_id' => $repo['id'],
                    ]
                );
                $project->tags()->sync($tagIds);

                $projects[] = $project;
            }

            return $projects;

        } catch (Exception $e) {
            throw new Exception("Error saving repositories as projects: " . $e->getMessage());
        }
    }

}
