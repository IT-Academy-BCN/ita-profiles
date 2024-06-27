<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Models\Project;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\ProjectNotFoundException;;
use Illuminate\Support\Facades\DB;

class StudentUpdateProjectService
{

    public function execute(string $studentId, string $projectId, array $data): Project
    {
        $student = Student::where('id', $studentId)->with('resume')->first();
        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume;
        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }

        $project = Project::find($projectId);
        if (!$project) {
            throw new ProjectNotFoundException($projectId);
        }

        DB::transaction(function () use ($project, $data) {
            $project->name = $data['project_name'];
            $project->company_name = $data['company_name'];
            $project->project_url = $data['project_url'] ?? null;
            $project->tags = json_encode($data['tags']);
            $project->github_url = $data['github_url'] ?? null;
            $project->save();
        });

        return $project;
    }
}
