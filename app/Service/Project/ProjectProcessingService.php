<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Service\Resume\ResumeService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ProjectProcessingService
{
    private GitHubProjectsService $gitHubProjectsService;
    private ResumeService $resumeService;

    public function __construct(GitHubProjectsService $gitHubProjectsService, ResumeService $resumeService)
    {
        $this->gitHubProjectsService = $gitHubProjectsService;
        $this->resumeService = $resumeService;
    }

    /**
     * @throws GuzzleException
     */
    public function processProject(): void
    {
        $resumes = $this->resumeService->getResumes();

        foreach ($resumes as $resume) {

            try {
                $gitHubUsername = $this->gitHubProjectsService->getGitHubUsername($resume);

                $repos = $this->gitHubProjectsService->fetchGitHubRepos($gitHubUsername);
                Log::info("GitHub Repos fetched for: " . $gitHubUsername);

                $projects = $this->gitHubProjectsService->saveRepositoriesAsProjects($repos);
                Log::info("Projects saved for: " . $gitHubUsername);

                $this->resumeService->saveProjectsInResume($projects, $resume);
                Log::info("Projects saved in Resume for: " . $gitHubUsername);

            } catch (Exception $e) {
                Log::error("Error processing GitHub projects: " . $e->getMessage());
            }
        }
    }
}
