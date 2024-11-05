<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Project;

use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function testUsesUuidAsPrimary_key()
    {
        $project = Project::factory()->create();

        $this->assertIsString($project->getKey());
        $this->assertEquals(36, strlen($project->getKey())); // Verifica que la longitud coincide con un UUID
    }

    public function testHasTagsRelationship()
    {
        $project = Project::factory()->create();
        $tag = Tag::factory()->create(['name' => 'TestTag']);

        // Attach tag to project
        $project->tags()->attach($tag);

        $this->assertInstanceOf(BelongsToMany::class, $project->tags());
        $this->assertTrue($project->tags->contains($tag));
    }

    public function testHasResumesRelationship()
    {
        $project = Project::factory()->create();
        $resume = Resume::factory()->create(['github_url' => 'TestResume']);

        $project->resumes()->attach($resume, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertInstanceOf(BelongsToMany::class, $project->resumes());
        $this->assertTrue($project->resumes->contains($resume));
        $this->assertNotNull($project->resumes->first()->pivot->created_at);
        $this->assertNotNull($project->resumes->first()->pivot->updated_at);
    }
}
