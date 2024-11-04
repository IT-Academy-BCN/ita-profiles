<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\Resume;
use App\Service\Project\ProjectProcessingService;
use App\Service\Resume\ResumeService;
use Exception;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

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
        try {
            if($resume->wasChanged('github_url')) {
                $originalGitHubUrl = app('originalGitHubUrl');
                $this->resumeService->deleteOldProjectsInResume($originalGitHubUrl, $resume);
                $this->projectProcessingService->processSingleResume($resume);
            }
        } catch (Exception $e) {
            Log::error("Error processing GitHub projects: " . "\n" . $e->getMessage());
        }
    }
}
