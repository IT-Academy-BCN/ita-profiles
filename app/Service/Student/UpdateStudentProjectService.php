<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Project;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Exception;

class UpdateStudentProjectService
{
    public function execute(string $studentId, string $projectId, array $data): void
    {
        DB::transaction(function () use ($studentId, $projectId, $data) {
            $student = $this->getStudent($studentId);
            $project = $this->getProject($projectId);

            // Verificar que el proyecto pertenece al estudiante
            if (!$this->isProjectOwnedByStudent($student, $project)) {
                throw new Exception("You do not have permission to update this project.", 403);
            }

            $this->updateProject($project, $student, $data);
        });
    }

    private function getStudent(string $studentId): Student
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new Exception("Student not found", 404);
        }

        return $student;
    }

    private function getProject(string $projectId): Project
    {
        $project = Project::find($projectId);

        if (!$project) {
            throw new Exception("Project not found", 404);
        }

        return $project;
    }

    private function isProjectOwnedByStudent(Student $student, Project $project): bool
    {
        return $student->resume->projects->contains($project);
    }

    private function updateProject(Project $project, Student $student, array $data): void
    {
        $project->name = $data['project_name'] ?? $project->name;
        $project->github_url = $data['github_url'] ?? $project->github_url;
        $project->project_url = $data['project_url'] ?? $project->project_url;
        $project->company_name = $data['company_name'] ?? $project->company_name;

        if (isset($data['tags'])) {
            $tagsArray = $data['tags'];
            $tagIds = Tag::whereIn('id', $tagsArray)->pluck('id')->toArray();
            $student->tags()->sync($tagIds);
        }

        $project->update();
    }
}
