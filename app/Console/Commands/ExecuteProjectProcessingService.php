<?php
declare(strict_types=1);

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

    public function handle(): void
    {
        $this->projectProcessingService->processAllResumes();
        $this->info('Project processing service executed at: ' . now());
    }
}
