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
            if (!is_null($resume->github_url)) {
                // For now I'll use if statement and Exception... if it's needed can be converted to try catch
                if (strpos($resume->github_url, 'https://github.com/') !== 0) {
                    throw new \Exception("Invalid GitHub URL: " . $resume->github_url);
                }
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
