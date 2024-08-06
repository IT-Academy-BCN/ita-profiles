<?php

namespace App\Providers;

use App\Service\Project\FetchGitHubReposService;
use App\Service\Project\ProcessedProjectsService;
use App\Service\Resume\GetGitHubUsernamesService;
use Illuminate\Support\Facades\Log;

class HandleProjectRetrieved
{
    private GetGitHubUsernamesService $getGitHubUsernamesService;
    private ProcessedProjectsService $processedProjectsService;
    private FetchGitHubReposService $fetchGitHubReposService;

    /**
     * Create the event listener.
     */
    public function __construct(GetGitHubUsernamesService $getGitHubUsernamesService, ProcessedProjectsService $processedProjectsService, FetchGitHubReposService  $fetchGitHubReposService)
    {
        $this->getGitHubUsernamesService = $getGitHubUsernamesService;
        $this->processedProjectsService = $processedProjectsService;
        $this->fetchGitHubReposService = $fetchGitHubReposService;
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;

        try {
            $gitHubUsername = $this->getGitHubUsernamesService->getSingleGitHubUsername($project);
        } catch (\Exception $e) {
            Log::error("Error retrieving GitHub username: " . $e->getMessage());
            return;
        }

        if (!$this->processedProjectsService->hasProcessedProject($gitHubUsername)) {
            // Marca el GitHub username como procesado
            $this->processedProjectsService->addProcessedProject($gitHubUsername);

            Log::info("Sending project model for GitHub username: " . $gitHubUsername);

            try {
                $this->fetchGitHubReposService->fetchGitHubRepos($gitHubUsername);
                //Log::info("Artisan command executed successfully.");
            } catch (\Exception $e) {
                //Log::error("Error executing Artisan command: " . $e->getMessage());
            }
        }
    }
}
