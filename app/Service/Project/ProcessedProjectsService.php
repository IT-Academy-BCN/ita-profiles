<?php

namespace App\Service\Project;

class ProcessedProjectsService
{
    private $processedProjects = [];

    public function addProcessedProject(string $gitHubUsername): void
    {
        $this->processedProjects[] = $gitHubUsername;
    }

    public function hasProcessedProject(string $gitHubUsername): bool
    {
        return in_array($gitHubUsername, $this->processedProjects);
    }
}
