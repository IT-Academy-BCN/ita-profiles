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
            $projectIds = array_column($projects, 'id');

            $resume->projects()->syncWithoutDetaching($projectIds);

            $resume->github_updated_at = now();
            $resume->save();

        } catch (Exception $e) {
            throw new Exception("Error saving projects in Resume: " .  $e->getMessage() . "\n");
        }
    }

    /**
     * @throws Exception
     */
    public function deleteOldProjectsInResume($originalGitHubUrl, Resume $resume): void
    {
        try {
            $projects = $resume->projects()
                ->where('github_url', 'like', "$originalGitHubUrl/%")
                ->get();

            foreach ($projects as $project) {
                $resume->projects()->detach($project);
                $project->delete();
            }
        } catch (Exception $e) {
            throw new Exception("Error deleting old projects in Resume: " . $e->getMessage() . "\n");
        }

    }
}