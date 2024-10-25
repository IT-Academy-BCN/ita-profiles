<?php

namespace App\Observers;

use App\Models\Resume;
use App\Service\Project\ProjectProcessingService;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ResumeObserver implements ShouldHandleEventsAfterCommit
{
    protected ProjectProcessingService $projectProcessingService;

    public function __construct(ProjectProcessingService $projectProcessingService)
    {
        $this->projectProcessingService = $projectProcessingService;
    }
    public function saved(Resume $resume): void
    {
        if($resume->wasChanged('github_url')) {
            $this->projectProcessingService->processSingleResume($resume);
        }
    }
}
