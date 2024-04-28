<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Project;
use App\Models\Tag;

class StudentProjectsDetailController extends Controller
{
    public function __invoke($uuid)
    {
        $student = Student::where('id', $uuid)->with('resume')->firstOrFail();
        $resume = $student->resume;

        $projectIds = json_decode($resume->project_ids);

        $projects = Project::findMany($projectIds);

        $projects_detail = [
            'projects' => $projects->map(function ($project) {
                $tags = Tag::findMany(json_decode($project->tags));
                return [
                    'uuid' => $project->id,
                    'project_name' => $project->name,
                    'company_name' => $project->company->name,
                    'project_url' => $project->project_url,
                    'tags' => $tags->pluck('tag_name')->join(' + '),
                    // 'tags_id' => $tags->pluck('id')->join(' + '), A la espera de si les hace falta a Front
                    'github_url' => $project->github_url,
                ];
            })
        ];
        
        return response()->json($projects_detail);
        
    }
   
}
