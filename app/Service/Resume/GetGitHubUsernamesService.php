<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Project;
use App\Models\Resume;

class GetGitHubUsernamesService
{
    private $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    // We have two possibilities here:
    // 1) Get the Resume using project_id and from there get the GitHub username (implemented).
    // 2) Get the GitHub username directly from project->github_url and trim the /projectname from url (not implemented).
    // MISSING TESTS!!!
    public function getSingleGitHubUsername(Project $project): string
    {
        $resume = $this->resumeService->getResumeByProjectId($project->id);

        // For now I'll use if statement and Exception... if it's needed can be converted to try catch
        if (is_null($resume->github_url)) {
            throw new \Exception("GutHub url not found");
        }

        $parsedUrl = parse_url($resume->github_url);
        if ($parsedUrl['host'] !== 'github.com' || empty($parsedUrl['path'])) {
            throw new \Exception("Invalid GitHub URL: " . $resume->github_url);
        }

        $username = trim($parsedUrl['path'], '/');
        return $username;
    }

    // Find the resume from the given github username
    public function getResumeByGitHubUsername(string $gitHubUsername): Resume
    {
        // Find first resume with the given github username at the end of the github_url
        $resume = Resume::where('github_url', 'regexp', "https://github.com/$gitHubUsername$")->first();
    
        if (is_null($resume)) {
            throw new \Exception("Resume not found for GitHub username: " . $gitHubUsername);
        }
    
        return $resume;
    }


    // This method is no longer needed, but I'll keep it for now. TESTS DONE.
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
