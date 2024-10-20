<?php

namespace App\Events;

use App\Models\Project;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectRetrieved
{
    use Dispatchable, SerializesModels;

    public Project $project;

    public function __construct($project)
    {
        $this->project = $project;
    }
}
