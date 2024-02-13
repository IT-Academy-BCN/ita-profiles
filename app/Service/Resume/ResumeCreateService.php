<?php


declare(strict_types=1);
namespace App\Service\Resume;
use App\Models\Resume;

class ResumeCreateService{

    public function execute(
        string $resumeId,
        string $studentId,
        ?string $subtitle = null,
        ?string $linkedinUrl = null,
        ?string $githubUrl = null,
        array $tagsIds = [],
        ?string $specialization = 'Not Set',
    ): Resume{
        $resume = Resume::create([
        'student_id' => $studentId,
        'subtitle' => $subtitle,
        'linkedin_url' => $linkedinUrl,
        'github_url' => $githubUrl,
        'tags_ids' => $tagsIds,
        'specialization' => $specialization,
        ]);
        
        return $resume;
    }
}
