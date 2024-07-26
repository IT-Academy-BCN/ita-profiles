<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Resume;

use App\Models\Project;
use App\Models\Resume;
use Tests\TestCase;
use App\Service\Resume\ResumeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResumeServiceTest extends TestCase
{
    use DatabaseTransactions;
    private $resumeService;

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeService = new ResumeService();
        // For some reason, if I don't delete the resumes here, the test fails because finds other Resumes...
        Resume::query()->delete();
    }

    public function testItRetrievesAListOfResumes()
    {
        Resume::factory()->count(3)->create();

        $resumes = $this->resumeService->getAll();

        $this->assertNotEmpty($resumes);
        $this->assertInstanceOf(Collection::class, $resumes);
        $this->assertCount(3, $resumes);
    }

    public function testItThrowsExceptionWhenNoResumesAreFound()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->resumeService->getAll();
    }

    public function testItGetsResumeByProjectId()
    {
        $project = Project::factory()->create();
        $resume = Resume::factory()->create([
            'project_ids' => json_encode([$project->id]),
        ]);

        $resumeService = new ResumeService();
        $foundResume = $resumeService->getResumeByProjectId($project->id);

        $this->assertEquals($resume->id, $foundResume->id);
    }

    public function testItThrowsExceptionWhenNoResumeIsFoundByProjectId()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->resumeService->getResumeByProjectId('non-existing-id');
    }
}
