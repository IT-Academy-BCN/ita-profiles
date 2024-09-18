<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Company;

class ProjectsForResume
{
    public static function createProjectsForResume($resumeId, $projectNames)
    {
        $projectIds = [];

        foreach ($projectNames as $projectName) {
            $project = new Project();
            $project->name = $projectName;
            $project->company_name = fake()->company; 
            $project->save();

            $projectIds[] = $project->id;
        }

        $resume = Resume::find($resumeId);
        $resume->project_ids = json_encode($projectIds);
        $resume->save();

        return $projectIds;
    }
}
