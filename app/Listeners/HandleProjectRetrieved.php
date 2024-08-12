<?php

namespace App\Listeners;

use App\Events\ProjectRetrieved;
use App\Service\Project\GitHubProjectsService;
use App\Service\Project\ProcessedProjectsService;
use App\Service\Resume\ResumeService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class HandleProjectRetrieved
{
    private GitHubProjectsService $gitHubProjectsService;
    private ProcessedProjectsService $processedProjectsService;
    private ResumeService $resumeService;

    // Create the event listener.
    public function __construct(GitHubProjectsService $gitHubProjectsService, ProcessedProjectsService $processedProjectsService, ResumeService $resumeService)
    {
        $this->gitHubProjectsService = $gitHubProjectsService;
        $this->processedProjectsService = $processedProjectsService;
        $this->resumeService = $resumeService;
    }

    // Handle the event.
    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;

        if (!$project->updated_at instanceof Carbon) {
            Log::warning("The 'updated_at' field is not a Carbon instance for project ID: {$project->id}");
            return;
        }

        // We don't want to process the project if updated_at is less than 1 hour ago
        $minutesBetweenUpdates = 60;
        if ($project->updated_at->diffInMinutes(now()) < $minutesBetweenUpdates) {
            Log::info("Project ID: {$project->id} skipped because it was updated less than {$minutesBetweenUpdates} minutes ago.");
            return;
        }

        try {
            $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($project);
        } catch (Exception $e) {
            Log::error("Error retrieving GitHub username: " . $e->getMessage());
            return;
        }

        if (!$this->processedProjectsService->hasProcessedProject($gitHubUsername)) {
            // Set the current GitHub username as processed
            $this->processedProjectsService->addProcessedProject($gitHubUsername);

            try {
                $repos = $this->gitHubProjectsService->fetchGitHubRepos($gitHubUsername);
                Log::info("GitHub Repos fetched for: " . $gitHubUsername);
                $projects = $this->gitHubProjectsService->saveRepositoriesAsProjects($repos);
                Log::info("Projects saved for: " . $gitHubUsername);
                $this->resumeService->saveProjectsInResume($projects, $gitHubUsername);
                Log::info("Projects saved in Resume for: " . $gitHubUsername);
            } catch (Exception $e) {
                Log::error("Error executing Logic: " . $e->getMessage());
            }
        }
    }
}
