<?php

namespace App\Providers;

use App\Service\Project\ProcessedProjectsService;
use App\Service\Resume\GetGitHubUsernamesService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class HandleProjectRetrieved
{
    private GetGitHubUsernamesService $getGitHubUsernamesService;
    private ProcessedProjectsService $processedProjectsService;

    /**
     * Create the event listener.
     */
    public function __construct(
        GetGitHubUsernamesService $getGitHubUsernamesService,
        ProcessedProjectsService $processedProjectsService
    ) {
        $this->getGitHubUsernamesService = $getGitHubUsernamesService;
        $this->processedProjectsService = $processedProjectsService;
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectRetrieved $event): void
    {
        // $project = $event->project;

        // try {
        //     $gitHubUsername = $this->getGitHubUsernamesService->getSingleGitHubUsername($project);
        //     Log::info("GitHub username retrieved: " . $gitHubUsername);
        // } catch (\Exception $e) {
        //     Log::error("Error retrieving GitHub username: " . $e->getMessage());
        //     return;
        // }

        // if (!$this->processedProjectsService->hasProcessedProject($gitHubUsername)) {
        //     // Marca el GitHub username como procesado
        //     $this->processedProjectsService->addProcessedProject($gitHubUsername);

        //     Log::info("Sending project model for GitHub username: " . $gitHubUsername);

        //     try {
        //         // Log the type and value of gitHubUsername
        //         Log::info("GitHub username before Artisan call: " . $gitHubUsername);

        //         // Ejecuta el comando de consola si es necesario
        //         Artisan::call('app:fetch-github-repos', [
        //             'gitHubUsername' => $gitHubUsername,
        //         ]);
        //         Log::info("Artisan command executed successfully.");
        //     } catch (\Exception $e) {
        //         Log::error("Error executing Artisan command: " . $e->getMessage());
        //     }
        // }
    }
}
