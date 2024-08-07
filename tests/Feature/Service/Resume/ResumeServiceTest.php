<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Resume;

use App\Models\Project;
use App\Models\Resume;
use Tests\TestCase;
use App\Service\Resume\ResumeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResumeServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $resumeService;
    private $project;

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeService = new ResumeService();
        // For some reason, if I don't delete the resumes here, the test fails because finds other Resumes...
        Resume::query()->delete();

        // Create the project once and reuse it in all tests
        $this->project = Project::factory()->create();
    }

    public function testItGetsResumeByProjectId()
    {
        $resume = Resume::factory()->create([
            'project_ids' => json_encode([$this->project->id]),
        ]);

        $foundResume = $this->resumeService->getResumeByProjectId($this->project->id);

        $this->assertEquals($resume->id, $foundResume->id);
    }

    public function testItThrowsExceptionWhenNoResumeIsFoundByProjectId()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->resumeService->getResumeByProjectId('non-existing-id');
    }

    public function testItGetsResumeByGitHubUsername()
    {
        $resume = Resume::factory()->create([
            'github_url' => 'https://github.com/user1',
            'project_ids' => json_encode([$this->project->id]),
        ]);

        $foundResume = $this->resumeService->getResumeByGitHubUsername('user1');

        $this->assertEquals($resume->id, $foundResume->id);
    }

    public function testItThrowsExceptionWhenResumeIsNull()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Resume not found for GitHub username: user2");

        $this->resumeService->getResumeByGitHubUsername('user2');
    }
}
