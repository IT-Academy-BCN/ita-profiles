<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Service\Project\ProjectProcessingService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExecuteProjectProcessingServiceTest extends TestCase
{
    use DatabaseTransactions;
    public function testCanExecuteProjectProcessingServiceCommand()
    {
        $projectProcessingServiceMock = $this->mock(ProjectProcessingService::class);
        $projectProcessingServiceMock->shouldReceive('processAllResumes')->once();

        $this->artisan('project:execute-project-processing-service')
            ->assertExitCode(0);
    }
}
