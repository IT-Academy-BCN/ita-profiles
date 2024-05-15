<?php

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\DevelopmentListService;
use Database\Factories\ResumeFactory;
use App\Models\Resume;

class DevelopmentListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $developmentListService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->developmentListService = new DevelopmentListService();
    }

    public function testDevelopmentListServiceReturnsAValidDevelopmentArrayForExistingResumesWithDevelopmentFieldWithValidData(): void
    {
        Resume::query()->delete();

        $developmentOptions = ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'];
        
        foreach ($developmentOptions as $development) {
            ResumeFactory::new()->specificDevelopment($development)->create();
        }

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

        $developmentList = $response->json();
        
        $this->assertCount(4, $developmentList);
        $this->assertContains('Spring', $developmentList);
        $this->assertContains('Laravel', $developmentList);
        $this->assertContains('Angular', $developmentList);
        $this->assertContains('React', $developmentList);
    }

    public function testDevelopmentListServiceReturnsAnEmptyArrayForExistingResumesWithDevelopmentFieldWithNotSetValue(): void
    {
        Resume::query()->delete();

        $development = 'Not Set';
    
        for ($i = 0; $i < 3; $i++) {
            ResumeFactory::new()->specificDevelopment($development)->create();
        }

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

        $developmentList = $response->json();

        $this->assertIsArray($developmentList);
        $this->assertEquals([], $developmentList);
    }

    public function testDevelopmentListServiceReturnsAnEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

        $developmentList = $response->json();

        $this->assertEquals([], $developmentList);
    }
}