<?php

namespace App\Providers;

use App\Service\Resume\GetGitHubUsernamesService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HandleProjectRetrieved
{
    private GetGitHubUsernamesService $getGitHubUsernamesService;

    /**
     * Create the event listener.
     */
    public function __construct(GetGitHubUsernamesService  $getGitHubUsernamesService )
    {
        $this->getGitHubUsernamesService = $getGitHubUsernamesService;
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;
        $gitHubUsername = $this->getGitHubUsernamesService->getSingleGitHubUsername($project);
        $processedProjects = Session::get('processed_projects', []);

        if (!in_array($gitHubUsername, $processedProjects)) {
            // Mark GitHub username as processed
            Session::push('processed_projects', $gitHubUsername);

            Log::info("Sending GitHub username: " . $gitHubUsername);

            // Call the FetchGithubRepos command
            Artisan::call('app:fetch-github-repos', [
                '--username' => $gitHubUsername
            ]);
        }

    }
}
