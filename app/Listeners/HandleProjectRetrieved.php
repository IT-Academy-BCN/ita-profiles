<?php

namespace App\Listeners;

use App\Events\ProjectRetrieved;
use App\Service\Project\GitHubProjectsService;
use App\Service\Resume\ResumeService;
use Exception;
use Illuminate\Support\Facades\Log;

class HandleProjectRetrieved
{
    private GitHubProjectsService $gitHubProjectsService;
    private ResumeService $resumeService;

    public function __construct(GitHubProjectsService $gitHubProjectsService, ResumeService $resumeService)
    {
        $this->gitHubProjectsService = $gitHubProjectsService;
        $this->resumeService = $resumeService;
    }

    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;
        Log::info("ProjectRetrieved: {$project->id}");
        $resume = $project->resumes()->first();

        $minutesBetweenUpdates = 0;

        try {
            if ($resume->pivot->updated_at->diffInMinutes(now()) < $minutesBetweenUpdates) {
                Log::info("Project ID: {$project->id} skipped because it was updated less than {$minutesBetweenUpdates} minutes ago.");
                return;
            }
        } catch (Exception $e) {
            Log::error("Error retrieving Resume: º" . $e->getMessage());
        }

        try {
            $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($project);
        } catch (Exception $e) {
            Log::error("Error retrieving GitHub username: " . $e->getMessage());
            return;
        }

        try {
            $repos = $this->gitHubProjectsService->fetchGitHubRepos($gitHubUsername);
            Log::info("GitHub Repos fetched for: " . $gitHubUsername);
            $projects = $this->gitHubProjectsService->saveRepositoriesAsProjects($repos);
            Log::info("Projects saved for: " . $gitHubUsername);
            $this->resumeService->saveProjects($projects, $resume);
            Log::info("Projects saved in Resume for: " . $gitHubUsername);
        } catch (Exception $e) {
            Log::error("Error executing Logic: " . $e->getMessage());
        }
    }

}
