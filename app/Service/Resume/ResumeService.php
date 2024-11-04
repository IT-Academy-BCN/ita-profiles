<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;
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

    public function saveProjectsInResume(array $projects, Resume $resume): void
    {
        $projectIds = array_column($projects, 'id');

        $resume->projects()->syncWithoutDetaching($projectIds);

        $resume->github_updated_at = now();
        $resume->save();
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
