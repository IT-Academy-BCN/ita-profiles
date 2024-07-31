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
}
