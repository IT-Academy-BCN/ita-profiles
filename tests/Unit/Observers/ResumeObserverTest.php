<?php

declare(strict_types=1);

namespace Tests\Unit\Observers;

use App\Models\Resume;
use App\Observers\ResumeObserver;
use App\Service\Project\ProjectProcessingService;
use App\Service\Resume\ResumeService;
use Exception;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class ResumeObserverTest extends TestCase
{
    protected ResumeService $resumeServiceMock;
    protected ProjectProcessingService $projectProcessingServiceMock;
    protected ResumeObserver $resumeObserver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resumeServiceMock = Mockery::mock(ResumeService::class);
        $this->projectProcessingServiceMock = Mockery::mock(ProjectProcessingService::class);

        $this->resumeObserver = new ResumeObserver(
            $this->resumeServiceMock,
            $this->projectProcessingServiceMock
        );
    }

    public function testUpdatedGithubUrlChanged()
    {
        $resume = Mockery::mock(Resume::class);
        $resume->shouldReceive('wasChanged')
            ->with('github_url')
            ->andReturn(true);
        $originalGitHubUrl = 'https://github.com/original-user';
        app()->instance('originalGitHubUrl', $originalGitHubUrl);

        $this->resumeServiceMock->shouldReceive('deleteOldProjectsInResume')
            ->with($originalGitHubUrl, $resume)
            ->once();

        $this->projectProcessingServiceMock->shouldReceive('processSingleResume')
            ->with($resume)
            ->once();

        $this->resumeObserver->updated($resume);
    }

    public function testUpdatedGithubUrlNotChanged()
    {
        $resume = Mockery::mock(Resume::class);
        $resume->shouldReceive('wasChanged')
            ->with('github_url')
            ->andReturn(false);

        $this->resumeServiceMock->shouldNotReceive('deleteOldProjectsInResume');
        $this->projectProcessingServiceMock->shouldNotReceive('processSingleResume');

        $this->resumeObserver->updated($resume);
    }

    public function testUpdatedHandlesExceptionAndLogsError()
    {
        Log::shouldReceive('error')
            ->once()
            ->with(Mockery::on(function ($message) {
                return str_contains($message, "Error processing GitHub projects");
            }));

        $resume = Mockery::mock(Resume::class);
        $resume->shouldReceive('wasChanged')
            ->with('github_url')
            ->andReturn(true);

        $originalGitHubUrl = 'https://github.com/original-user';
        app()->instance('originalGitHubUrl', $originalGitHubUrl);

        $this->resumeServiceMock->shouldReceive('deleteOldProjectsInResume')
            ->andThrow(new Exception('Test exception'));

        $this->resumeObserver->updated($resume);
    }
}
