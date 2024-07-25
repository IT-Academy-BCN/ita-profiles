<?php

declare(strict_types=1);

namespace App\Service\Resume;

class GetGitHubUsernamesService
{
    private $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }
    
    public function getGitHubUsernames(): array
    {
        $resumes = $this->resumeService->getAll();
        $gitHubUsernames = [];
        foreach ($resumes as $resume) {
            // Quedaría hacer verificaciones... con el handler que prepara Iván o try catch.
            // VALIDATIONS
            if (!is_null($resume->github_url)) {
                $gitHubUsername = str_replace('https://github.com/', '', $resume->github_url);

                $gitHubUsernames[] = [
                    'resume_id' => $resume->id,
                    'github_username' => $gitHubUsername,
                ];
            }
        }

        return $gitHubUsernames;
    }
}
