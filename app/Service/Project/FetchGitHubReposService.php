<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Console\Command;
use App\Service\Resume\GetGitHubUsernamesService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchGitHubReposService
{
    public function fetchGitHubRepos($gitHubUsername): void
    {
        $repos = $this->fetchRepositories($gitHubUsername);
        $projects = $this->saveRepositoriesAsProjects($repos);
        $this->saveProjectsInResume($projects, $gitHubUsername);
    }

    protected function fetchRepositories(string $gitHubUsername): array
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
                // Criterio de búsqueda: el ID del repositorio de Github podría ser útil para esto. Si el ID existe, actualiza y si no,
                // crea un nuevo Project. Pero para que esto funcione tuve que crear la columna en la tabla Project.
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

    public function saveProjectsInResume(array $projects, string $gitHubUsername): void
    {
        // Get the resume that matches the given GitHub username.
        $resume = $this->getGitHubUsernamesService->getResumeByGitHubUsername($gitHubUsername);
        // Get the current project_ids array
        $projectIds = json_decode($resume->project_ids, true) ?? [];

        foreach ($projects as $project) {
            // Add the new project ID to the array
            $projectIds[] = $project['id'];
        }
        // Update the project_ids array in the Resume
        $resume->project_ids = json_encode(array_unique($projectIds));
        // Save the updated Resume
        $resume->save();
    }
}

