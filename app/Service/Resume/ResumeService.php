<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ResumeService
{

    public function getResumes(): Collection
    {
        $timeBetweenUpdates = 60;

        return Resume::whereNotNull('github_url')
            ->whereNull('github_updated_at')
            ->orWhere('github_updated_at', '<', now()->subMinutes($timeBetweenUpdates))
            ->get();
    }

    /**
     * @throws Exception
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
            throw new Exception($e->getMessage());
        }
    }

    public function deleteOldProjectsInResume($originalGitHubUrl, Resume $resume): void
    {
        $projects = $resume->projects()
            ->where('github_url', 'like', "$originalGitHubUrl/%")
            ->get();

        foreach ($projects as $project) {
            $resume->projects()->detach($project);
            $project->delete();
        }
    }
}
