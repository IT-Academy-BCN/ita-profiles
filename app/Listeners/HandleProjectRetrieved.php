<?php

namespace App\Listeners;

use App\Events\ProjectRetrieved;
use App\Service\Project\ProjectProcessingService;

class HandleProjectRetrieved
{
    private ProjectProcessingService $projectProcessingService;

    public function __construct(ProjectProcessingService $projectProcessingService)
    {
        $this->projectProcessingService = $projectProcessingService;
    }

    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;
        $this->projectProcessingService->processProject($project);
    }

}
