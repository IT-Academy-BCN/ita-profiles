<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Resume;

use App\Models\Project;
use App\Models\Resume;
use App\Service\Resume\ResumeService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ResumeServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected ResumeService $resumeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resumeService = new ResumeService();
    }

    public function testCanGetResumes()
    {
        $resume1 = Resume::factory()->create([
            'github_url' => 'https://github.com/testuser1',
            'github_updated_at' => null
        ]);

        $resume2 = Resume::factory()->create([
            'github_url' => 'https://github.com/testuser2',
            'github_updated_at' => now()->subMinutes(61)
        ]);

        $resume3 = Resume::factory()->create([
            'github_url' => 'https://github.com/testuser3',
            'github_updated_at' => now()->subMinutes(30)
        ]);

        $resumes = $this->resumeService->getResumes();

        $this->assertInstanceOf(Collection::class, $resumes);
        $this->assertTrue($resumes->contains($resume1));
        $this->assertTrue($resumes->contains($resume2));
        $this->assertFalse($resumes->contains($resume3));
    }

    public function testCanSaveProjectsInResume()
    {
        $resume = Resume::factory()->create(['github_url' => 'https://github.com/testuser']);
        $existingProject = Project::factory()->create();
        $resume->projects()->attach($existingProject);

        $newProjects = [
            Project::factory()->create(['name' => 'New Project 1']),
            Project::factory()->create(['name' => 'New Project 2'])
        ];

        $this->resumeService->saveProjectsInResume($newProjects, $resume);

        $resume->refresh();

        $projectIds = $resume->projects->pluck('id')->toArray();
        $this->assertContains($existingProject->id, $projectIds);
        $this->assertContains($newProjects[0]->id, $projectIds);
        $this->assertContains($newProjects[1]->id, $projectIds);

        $this->assertNotNull($resume->github_updated_at);
        $this->assertTrue($resume->wasChanged('github_updated_at'));
    }

    public function testCanHandleExceptionInSaveProjectsInResume()
    {
        // Crear un resume válido
        $resume = Resume::factory()->create(['github_url' => 'https://github.com/testuser']);
        $projects = [
            Project::factory()->create(['id' => 1, 'name' => 'Existing Project']),
        ];

        /** @var Resume|MockInterface $resume */
        $resume = Mockery::mock($resume);
        $resume->shouldReceive('projects->sync')
            ->andThrow(new Exception("Error syncing projects"));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Error syncing projects");

        $this->resumeService->saveProjectsInResume($projects, $resume);
    }

    public function testCanDeleteOldProjectsInResume()
    {
        $originalGitHubUrl = 'https://github.com/testuser';

        $resume = Resume::factory()->create();
        $project1 = Project::factory()->create(['github_url' => "$originalGitHubUrl/project1"]);
        $project2 = Project::factory()->create(['github_url' => "$originalGitHubUrl/project2"]);
        $unrelatedProject = Project::factory()->create(['github_url' => 'https://github.com/otheruser/project3']);

        $resume->projects()->attach([$project1->id, $project2->id, $unrelatedProject->id]);

        $this->resumeService->deleteOldProjectsInResume($originalGitHubUrl, $resume);

        $this->assertFalse($resume->projects->contains($project1));
        $this->assertFalse($resume->projects->contains($project2));
        $this->assertTrue($resume->projects->contains($unrelatedProject));

        $this->assertDatabaseMissing('projects', ['id' => $project1->id]);
        $this->assertDatabaseMissing('projects', ['id' => $project2->id]);
        $this->assertDatabaseHas('projects', ['id' => $unrelatedProject->id]);
    }
}
