<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Exceptions\ResumeServiceException;
use App\Models\Project;
use App\Models\Resume;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResumeService
{
    public function saveProjectsInResume(array $projects, Resume $resume): void
    {
        try {
            // Desactiva los eventos para el modelo Project mientras se ejecuta este bloque
            Project::withoutEvents(function () use ($projects, $resume) {
                //$resume = $this->getResumeByGitHubUsername($gitHubUsername);

                // Obtener el array actual de project_ids
                $projectIds = $resume->projects->pluck('id')->toArray();

                foreach ($projects as $project) {
                    $projectIds[] = $project['id'];
                }

                // Actualiza el array de project_ids en el Resume
                $resume->projects()->sync(array_fill_keys(array_unique($projectIds), ['updated_at' => now()]));

            });
        } catch (Exception $e) {
            throw new ResumeServiceException($e->getMessage());
        }
    }
}
