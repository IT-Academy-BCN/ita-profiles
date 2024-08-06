<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Models\Project;
use App\Models\Company;
use App\Service\Resume\ResumeService;
use GuzzleHttp\Client;

class GitHubProjectsService
{
    private $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    // We have two possibilities here:
    // 1) Get the Resume using project_id and from there get the GitHub username (implemented).
    // 2) Get the GitHub username directly from project->github_url and trim the /projectname from url (not implemented).
    public function getGitHubUsername(Project $project): string
    {
        $resume = $this->resumeService->getResumeByProjectId($project->id);

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
    }

    public function fetchGitHubRepos(string $gitHubUsername): array
    {
        $client = new Client;

        $response = $client->get("https://api.github.com/users/{$gitHubUsername}/repos", [
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'LaravelApp'
            ],
            'synchronous' => true
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function saveRepositoriesAsProjects(array $repos): array
    {
        $projects = [];

        foreach ($repos as $repo) {
            // Need a Company because this DB is like it is.
            $company = Company::firstOrFail();

            // Desactivar temporalmente los eventos para evitar disparar el evento retrieved
            Project::withoutEvents(function () use ($repo, $company, &$project) {
                $project = Project::updateOrCreate(
                    // Criterio de búsqueda: el ID del repositorio de Github podría ser útil para esto. Si el ID existe, actualiza y si no crea un nuevo Project. 
                    // Pero para que esto funcione tuve que crear la columna en la tabla Project.
                    ['github_repository_id' => $repo['id']],
                    [
                        'user' => $repo['owner']['login'],
                        'name' => $repo['name'],
                        'github_url' => $repo['html_url'],
                        // Los lenguajes serán otro problema porque se almacenan como un array de IDs, por lo que deberíamos coincidir el ID del lenguaje...
                        //'tags' => $repo['languages_url'],
                        // Obligatorio... Se debería poder poner null en el campo y establecer un valor "Freelance" en caso de ser null.
                        'company_id' => $company->id,
                        'github_repository_id' => $repo['id'],
                    ]
                );
            });

            $projects[] = $project;
        }

        return $projects;
    }
}
