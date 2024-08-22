<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResumeService
{
    public function getResumeByProjectId(string $projectId): Resume
    {
        try {
            $resume = Resume::whereJsonContains('project_ids', $projectId)->first();
            if (is_null($resume)) {
                throw new ModelNotFoundException('Resume not found.');
            }
            return $resume;
        } catch (ModelNotFoundException $e) {
            throw $e; // Re-throw the specific exception
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving resume by project ID: " . $e->getMessage());
        }
    }

    public function getResumeByGitHubUsername(string $gitHubUsername): Resume
    {
        try {
            // Find first resume with the given github username at the end of the github_url. IMPORTANT: It won't work
            // if there are more than one resume with the same github username, will apply to the first one, not the rest.
            $resume = Resume::where('github_url', 'regexp', "https://github.com/$gitHubUsername$")->first();
            if (is_null($resume)) {
                throw new \Exception("Resume not found for GitHub username: " . $gitHubUsername);
            }
            return $resume;
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving resume by GitHub username: " . $e->getMessage());
        }
    }

    public function saveProjectsInResume(array $projects, string $gitHubUsername): void
    {
        try {
            $resume = $this->getResumeByGitHubUsername($gitHubUsername);
            // Get the current project_ids array
            $projectIds = json_decode($resume->project_ids, true) ?? [];
            foreach ($projects as $project) {
                $projectIds[] = $project['id'];
            }
            // Update the project_ids array in the Resume
            $resume->project_ids = json_encode(array_unique($projectIds));
            $resume->save();
        } catch (\Exception $e) {
            throw new \Exception("Error saving projects in Resume: " . $e->getMessage());
        }
    }
}
