<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;

class ResumeUpdateService
{
    public function execute(
        string $resumeId,
        ?string $subtitle = null,
        ?string $linkedinUrl = null,
        ?string $githubUrl = null,
        ?string $specialization = null
    ): void {
        $resume = Resume::find($resumeId);

        if ($subtitle !== null) {
            $resume->subtitle = $subtitle;
        }

        if ($linkedinUrl !== null) {
            $resume->linkedin_url = $linkedinUrl;
        }

        if ($githubUrl !== null) {
            $resume->github_url = $githubUrl;
        }

        if ($specialization !== null) {
            $resume->specialization = $specialization;
        }

        $resume->save();
    }
}
