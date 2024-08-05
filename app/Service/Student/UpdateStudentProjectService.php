<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Project;
use App\Models\Student;
use App\Models\Company;
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
            if (!$this->isProjectOwnedByStudent($studentId, $projectId)) {
                throw new Exception("No tienes permiso para actualizar este proyecto.", 403);
            }

            $this->updateProject($project, $data);
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

    private function isProjectOwnedByStudent(string $studentId, string $projectId): bool
    {
        return Student::where('id', $studentId)
            ->whereHas('resume', function ($query) use ($projectId) {
                $query->where('project_ids', 'like', "%$projectId%");
            })->exists();
    }

    private function updateProject(Project $project, array $data): void
    {
        $project->name = $data['project_name'] ?? $project->name;
        $project->github_url = $data['github_url'] ?? $project->github_url;
        $project->project_url = $data['project_url'] ?? $project->project_url;

        if (isset($data['tags'])) {
            $tagsArray = $data['tags'];
            $tagIds = Tag::whereIn('id', $tagsArray)->pluck('id')->toArray();
            $project->tags = json_encode($tagIds);
        }
        if (isset($data['company_name'])) {
            $company = Company::find($project->company_id);
            if ($company) {
                $company->name = $data['company_name'];
                $company->save();
            }
        }

        $project->update();
    }
}
