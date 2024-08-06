<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResumeService
{
    public function getResumeByProjectId(string $projectId): Resume
    {
        $resume = Resume::whereJsonContains('project_ids', $projectId)->first();
        if (is_null($resume)) {
            throw new ModelNotFoundException('Resume not found.');
        }

        return $resume;
    }

    public function getResumeByGitHubUsername(string $gitHubUsername): Resume
    {
        // Find first resume with the given github username at the end of the github_url
        // OJO QUE PILLA EL PRIMER RESUME, SI HAY MÁS DE UNO CON EL MISMO GITHUB USERNAME 
        // NO VA A FUNCIONAR EN EL SEGUNDO Y LO APLICARÁ AL PRIMERO
        $resume = Resume::where('github_url', 'regexp', "https://github.com/$gitHubUsername$")->first();

        if (is_null($resume)) {
            throw new \Exception("Resume not found for GitHub username: " . $gitHubUsername);
        }

        return $resume;
    }

    public function saveProjectsInResume(array $projects, string $gitHubUsername): void
    {
        $resume = $this->getResumeByGitHubUsername($gitHubUsername);
        // Get the current project_ids array
        $projectIds = json_decode($resume->project_ids, true) ?? [];

        foreach ($projects as $project) {
            $projectIds[] = $project['id'];
        }
        // Update the project_ids array in the Resume
        $resume->project_ids = json_encode(array_unique($projectIds));

        $resume->save();
    }
}
