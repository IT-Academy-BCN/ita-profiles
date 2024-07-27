<?php

namespace App\Providers;

use App\Models\Resume;
use App\Providers\ProjectRetrieved;
use App\Service\Resume\ResumeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HandleProjectRetrieved
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectRetrieved $event): void
    {
        $project = $event->project;
        $resumeService = new ResumeService();
        $resume = $resumeService->getResumeByProjectId($project->id);
        $resumeId = $resume->id;
        $processedResumeIds = Session::get('processed_resume_ids', []);

        if (!in_array($resumeId, $processedResumeIds)) {
            // Mark resumeId as processed
            Session::push('processed_resume_ids', $resumeId);

            Log::info("Sending project model for resumeId: " . $resumeId);
        }

    }
}
