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

        $company = Company::first();
        if (!$company) {
            
            $company = Company::create(['name' => 'Test Company']);
        }

        foreach ($projectNames as $projectName) {
            $project = new Project();
            $project->name = $projectName;
            $project->company_id = $company->id; 
            $project->save();

            $projectIds[] = $project->id;
        }

        $resume = Resume::find($resumeId);
        $resume->project_ids = json_encode($projectIds);
        $resume->save();

        return $projectIds;
    }
}
