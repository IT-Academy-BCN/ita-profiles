<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Exceptions\ResumeServiceException;
use App\Models\Resume;
use Exception;

class ResumeService
{
    /**
     * @throws ResumeServiceException
     */
    public function saveProjectsInResume(array $projects, Resume $resume): void
    {
        try {
            // Obtener el array actual de project_ids
            $projectIds = $resume->projects->pluck('id')->toArray();

            foreach ($projects as $project) {
                $projectIds[] = $project['id'];
            }

            $resume->projects()->sync(array_unique($projectIds));

            $resume->github_updated_at = now();
            $resume->save();

        } catch (Exception $e) {
            throw new ResumeServiceException($e->getMessage());
        }
    }
}
