<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Resume;
use Illuminate\Database\Eloquent\Collection;
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

    // No longer needed if the method getSingleGitHubUsername is used.
    public function getAll(): Collection
    {
        $resumes = Resume::all();
        if ($resumes->isEmpty()) {
            throw new ModelNotFoundException('No resumes found.');
        }

        return $resumes;
    }
}
