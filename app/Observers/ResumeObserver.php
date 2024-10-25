<?php

namespace App\Observers;

use App\Models\Resume;
use App\Service\Project\ProjectProcessingService;
use App\Service\Resume\ResumeService;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ResumeObserver implements ShouldHandleEventsAfterCommit
{

    private ResumeService $resumeService;
    protected ProjectProcessingService $projectProcessingService;

    public function __construct(ResumeService $resumeService, ProjectProcessingService $projectProcessingService)
    {
        $this->resumeService = $resumeService;
        $this->projectProcessingService = $projectProcessingService;
    }
    public function updated(Resume $resume): void
    {
        if($resume->wasChanged('github_url')) {
            $originalGitHubUrl = app('originalGitHubUrl');
            $this->resumeService->deleteOldProjectsInResume($originalGitHubUrl, $resume);
            $this->projectProcessingService->processSingleResume($resume);
        }
    }
}
