<?php

namespace App\Providers;

use App\Service\Project\ProcessedProjectsService;
use App\Service\Resume\GetGitHubUsernamesService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
    )
    {
        $this->getGitHubUsernamesService = $getGitHubUsernamesService;
        $this->processedProjectsService = $processedProjectsService;
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;
        $gitHubUsername = $this->getGitHubUsernamesService->getSingleGitHubUsername($project);

        if (!$this->processedProjectsService->hasProcessedProject($gitHubUsername)) {
            // Marca el GitHub username como procesado
            $this->processedProjectsService->addProcessedProject($gitHubUsername);

            Log::info("Sending project model for GitHub username: " . $gitHubUsername);

            // Ejecuta el comando de consola si es necesario
//            Artisan::call('app:fetch-github-repos', [
//                'gitHubUsername' => $gitHubUsername,
//            ]);
        }
    }
}
