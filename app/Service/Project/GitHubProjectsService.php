<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use App\Service\Resume\ResumeService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GitHubProjectsService
{
    private $resumeService;
    protected $githubToken;
    private $client;

    public function __construct(ResumeService $resumeService, Client $client = null)
    {
        $this->resumeService = $resumeService;
        $this->githubToken = config('github.token');
        $this->client = $client ?? new Client;

        /*if (is_null($this->githubToken)) {
            Log::error("GitHub token not found");
            throw new \Exception("GitHub token not found");
        }*/
    }

    // We have two possibilities here:
    // 1) Get the Resume using project_id and from there get the GitHub username (implemented).
    // 2) Get the GitHub username directly from project->github_url and trim the /projectname from url (not implemented).
    public function getGitHubUsername(Project $project): string
    {
        try {
            $resume = Resume::whereRelation('projects', 'projects.id', '=', $project->id)->first();

            // For now I'll use if statement and Exception... if it's needed can be converted to try catch
            if (is_null($resume->github_url)) {
                throw new \Exception("GutHub url not found");
            }

            $parsedUrl = parse_url($resume->github_url);
            if ($parsedUrl['host'] !== 'github.com' || empty($parsedUrl['path'])) {
                throw new \Exception("Invalid GitHub URL: " . $resume->github_url);
            }

            $username = trim($parsedUrl['path'], '/');
            return $username;
        } catch (\Exception $e) {
            throw new \Exception("Error processing GitHub username: " . $e->getMessage());
        }
    }

    public function fetchGitHubRepos(string $gitHubUsername): array
    {
        try {
            $headers = [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'LaravelApp',
            ];

            if ($this->githubToken) {
                $headers['Authorization'] = "Bearer {$this->githubToken}";
            }

            $response = $this->client->get("https://api.github.com/users/{$gitHubUsername}/repos", [
                'headers' => $headers,
                'synchronous' => true
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching GitHub repositories: " . $e->getMessage());
        }
    }

    public function fetchRepoLanguages(string $languagesUrl): array
    {
        try {
            $headers = [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'LaravelApp',
            ];

            if ($this->githubToken) {
                $headers['Authorization'] = "Bearer {$this->githubToken}";
            }

            $response = $this->client->get($languagesUrl, [
                'headers' => $headers,
                'synchronous' => true
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching GitHub repository languages: " . $e->getMessage());
        }
    }

    public function saveRepositoriesAsProjects(array $repos): array
    {
        try {
            $projects = [];
            // Cache tags to avoid repeated database queries
            $allTags = Tag::all();

            foreach ($repos as $repo) {
                $languages = $this->fetchRepoLanguages($repo['languages_url']);
                $languageNames = array_keys($languages);
                $tagIds = $allTags->whereIn('name', $languageNames)->pluck('id')->toArray();
                // Desactivar temporalmente los eventos para evitar disparar el evento retrieved
                Project::withoutEvents(function () use ($repo, &$project, $tagIds) {
                    $project = Project::updateOrCreate(
                        // Criterio de búsqueda: el ID del repo de Github. Si el ID existe, actualiza y si no crea un nuevo Project.
                        // Pero para que esto funcione tuve que crear la columna en la tabla Project.
                        ['github_repository_id' => $repo['id']],
                        [
                            'user' => $repo['owner']['login'],
                            'name' => $repo['name'],
                            'github_url' => $repo['html_url'],
                            'github_repository_id' => $repo['id'],
                        ]
                    );
                    $project->tags()->sync($tagIds);
                });

                $projects[] = $project;
            }

            return $projects;
        } catch (\Exception $e) {
            throw new \Exception("Error saving repositories as projects: " . $e->getMessage());
        }
    }
}
