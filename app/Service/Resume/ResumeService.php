<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Project;
use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResumeService
{

    public function getResumeByGitHubUsername(string $gitHubUsername): Resume
    {
        try {
            // Find first resume with the given github username at the end of the github_url. IMPORTANT: It won't work
            // if there are more than one resume with the same github username, will apply to the first one, not the rest.
            $resume = Resume::where('github_url', 'regexp', "https://github.com/$gitHubUsername$")->first();
            if (is_null($resume)) {
                throw new \Exception("Resume not found for GitHub username: " . $gitHubUsername);
            }
            return $resume;
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving resume by GitHub username: " . $e->getMessage());
        }
    }

    public function saveProjects(array $projects, string $gitHubUsername): void
    {
        try {
            // Desactiva los eventos para el modelo Project mientras se ejecuta este bloque
            Project::withoutEvents(function () use ($projects, $gitHubUsername) {
                $resume = $this->getResumeByGitHubUsername($gitHubUsername);

                // Obtener el array actual de project_ids
                $projectIds = $resume->projects->pluck('id')->toArray();

                foreach ($projects as $project) {
                    $projectIds[] = $project['id'];
                }

                // Actualiza el array de project_ids en el Resume
                $resume->projects()->sync(array_unique($projectIds));

                foreach ($projectIds as $projectId) {
                    $resume->projects()->updateExistingPivot($projectId, ['updated_at' => now()]);
                }
            });
        } catch (\Exception $e) {
            throw new \Exception("Error saving projects in Resume: " . $e->getMessage());
        }
    }
}
