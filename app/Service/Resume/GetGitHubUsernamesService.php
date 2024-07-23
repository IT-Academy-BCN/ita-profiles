<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;

class getGitHubUsernamesService
{
    public function GetGitHubUsernames(): array
    {
        // Get all resumes, maybe this could be refactored to a ResumeService.php function getAll.
        $resumes = Resume::all();
        $gitHubUsernames = [];
        foreach ($resumes as $resume) {
            // Quedaría hacer verificaciones... con el handler que prepara Iván o try catch.
            // VALIDATIONS
            if (!is_null($resume->github_url)) {
                // We remove the 'https://github.com/' from github_url and leave only the username.
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
