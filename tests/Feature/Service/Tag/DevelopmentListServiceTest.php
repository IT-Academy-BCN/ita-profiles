<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Tag\DevelopmentListService;
use Database\Factories\ResumeFactory;
use App\Models\Resume;

class DevelopmentListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $developmentListService;

    protected function setUp(): void
    {
        parent::setUp();

        Resume::query()->delete();

        $this->developmentListService = new DevelopmentListService();
    }

    public function testDevelopmentListServiceReturnsAValidDevelopmentArrayForExistingResumesWithDevelopmentFieldWithValidData(): void
    {
        $developmentOptions = ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'];

        foreach ($developmentOptions as $development) {
            Resume::factory()->create(['development' => $development]);
        }

        $response = $this->developmentListService->execute();

        $this->assertCount(4, $response);
        $this->assertContains('Spring', $response);
        $this->assertContains('Laravel', $response);
        $this->assertContains('Angular', $response);
        $this->assertContains('React', $response);
    }

    public function testDevelopmentListServiceReturnsAnEmptyArrayForExistingResumesWithDevelopmentFieldWithNotSetValue(): void
    {
        $development = 'Not Set';

        Resume::factory()->count(3)->create(['development' => $development]);

        $response = $this->developmentListService->execute();

        $this->assertIsArray($response);

        $this->assertEquals([], $response);
    }

    public function testDevelopmentListServiceReturnsAnEmptyArrayWhenNoResumes(): void
    {
        $response = $this->developmentListService->execute();

        $this->assertEquals([], $response);
    }

    public function testDevelopmentListServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(DevelopmentListService::class, $this->developmentListService);
    }
}
