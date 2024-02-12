<?php


declare(strict_types=1);
namespace App\Service\Resume;
use App\Models\Resume;

class ResumeCreateServie{

    public function execute(
        string $resumeId,
        string $studentId,
        ?string $subtitle = null,
        ?string $linkedinUrl = null,
        ?string $githubUrl = null,
        array $tagsIds = [],
        ?string $specialization = 'Not Set',
    ): Resume{
        $resume = new Resume();
        $resume->student_id = $studentId;
        $resume->subtitle = $subtitle;
        $resume->linkedin_url = $linkedinUrl;
        $resume->github_url = $githubUrl;
        $resume->tags_ids = $tagsIds;
        $resume->specialization = $specialization;

        $resume->save();
        
        return $resume;
    }
}
