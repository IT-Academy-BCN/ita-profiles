<?php

namespace App\Service\Project;

use Illuminate\Support\Facades\Log;

class ProcessedProjectsService
{
    private $processedProjects = [];

    public function addProcessedProject(string $gitHubUsername): void
    {
        Log::info("Adding processed project for GitHub username: " . $gitHubUsername);
        $this->processedProjects[] = $gitHubUsername;
    }

    public function hasProcessedProject(string $gitHubUsername): bool
    {
        $hasProcessed = in_array($gitHubUsername, $this->processedProjects);
        Log::info("Checking if project has been processed for GitHub username: " . $gitHubUsername . " - " . ($hasProcessed ? "Yes" : "No"));
        return $hasProcessed;
    }
}
