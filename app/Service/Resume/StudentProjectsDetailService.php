<?php

declare(strict_types=1);

namespace App\Service\Resume;

use App\Models\Student;
use App\Models\Project;
use App\Models\Tag;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\ProjectNotFoundException;

class StudentProjectsDetailService
{
    public function execute($uuid)
    {
        $student = Student::where('id', $uuid)->with('resume')->first();
        if (!$student) {
            throw new StudentNotFoundException($uuid);
        }

        $resume = $student->resume;

        if (!$resume) {
            throw new ResumeNotFoundException($uuid);
        }

        $projectIds = json_decode($resume->project_ids);

        $projects = Project::findMany($projectIds);

        if ($projects->isEmpty()) {
            throw new ProjectNotFoundException($uuid);
        }

        $projects_detail = [
            'projects' => $projects->map(function ($project) {
                $tags = Tag::findMany(json_decode($project->tags));
                return [
                    'uuid' => $project->id,
                    'project_name' => $project->name,
                    'company_name' => $project->company->name,
                    'project_url' => $project->project_url,
                    'tags' => $tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->tag_name,
                        ];
                    })->toArray(),
                    'github_url' => $project->github_url,
                ];
            })
        ];

        return $projects_detail;
    }
}
