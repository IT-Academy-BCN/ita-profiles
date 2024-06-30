<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Project;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;

class StudentUpdateProjectService
{
    public function execute(string $studentId, string $projectId, array $data): void
    {
        DB::transaction(function () use ($studentId, $projectId, $data) {
            $this->ensureStudentExists($studentId);
            $project = $this->getProject($projectId);

            $this->updateProject($project, $data);
        });
    }

    private function ensureStudentExists(string $studentId): void
    {
        if (!Student::find($studentId)) {
            throw new StudentNotFoundException($studentId);
        }
    }

    private function getProject(string $projectId): Project
    {
        $project = Project::find($projectId);

        if (!$project) {
            throw new ProjectNotFoundException($projectId);
        }

        return $project;
    }

    private function updateProject(Project $project, array $data): void
    {
        $project->name = $data['name'] ?? $project->name;
        $project->tags = json_encode($data['tags'] ?? json_decode($project->tags));
        $project->github_url = $data['github_url'] ?? $project->github_url;
        $project->project_url = $data['project_url'] ?? $project->project_url;
        $project->save();
    }
}
