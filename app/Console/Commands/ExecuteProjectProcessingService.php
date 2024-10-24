<?php

namespace App\Console\Commands;

use App\Service\Project\ProjectProcessingService;
use Illuminate\Console\Command;

class ExecuteProjectProcessingService extends Command
{

    protected $signature = 'project:execute-project-processing-service';
    protected $description = 'Execute the project processing service';

    protected ProjectProcessingService $projectProcessingService;

    public function __construct(ProjectProcessingService $projectProcessingService)
    {
        parent::__construct();
        $this->projectProcessingService = $projectProcessingService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->projectProcessingService->processAllResumes();
        $this->info('Project processing service executed at: ' . now());
    }
}
