<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Project;
use App\Models\Student;
use App\Models\Company;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ProjectNotFoundException;
use App\Exceptions\UnauthorizedException;


class UpdateStudentProjectService
{
    public function execute(string $studentId, string $projectId, array $data): void
    {
        DB::transaction(function () use ($studentId, $projectId, $data) {
            $this->getStudent($studentId);
            $project = $this->getProject($projectId);
            $this->updateProject($project, $data);
        });
    }

    private function getStudent(string $studentId): void
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
        $project->name = $data['project_name'] ?? $project->name;
        //$project->tags = json_encode($data['tags'] ?? json_decode($project->tags));
        $project->github_url = $data['github_url'] ?? $project->github_url;
        $project->project_url = $data['project_url'] ?? $project->project_url;
        
        if (isset($data['tags'])) {           
            $tagsArray = $data['tags'];
            $tags = Tag::whereIn('tag_name', $tagsArray)->get();
            $tagIds = $tags->pluck('id')->toArray();
            $project->tags = json_encode($tagIds);
        }
        if (isset($data['company_name'])) {
            $company = Company::find($project->company_id);
            $company->name = $data['company_name'];
            $company->save();
            }   

        $project->save();
    }
}
