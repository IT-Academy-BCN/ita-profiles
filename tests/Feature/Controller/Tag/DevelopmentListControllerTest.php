<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Database\Factories\ResumeFactory;
use App\Models\Resume;
use App\Http\Controllers\api\DevelopmentListController;
use App\Service\DevelopmentListService;

class DevelopmentListControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testDevelopmentListControllerReturns_200StatusAndValidDevelopmentListForResumesWithValidDevelopmentOptions(): void
    {
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

    public function testDevelopmentListControllerReturns_200StatusAndEmptyArrayForResumesWithNotSetDevelopmentOption(): void
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

    public function testDevelopmentListControllerReturns_200StatusAndEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

        $developmentList = $response->json();

        $this->assertEquals([], $developmentList);
    }

    public function testDevelopmentListControllerCanBeInstantiated(): void
    {
        $developmentListService = $this->createMock(DevelopmentListService::class);
        
        $controller = new DevelopmentListController($developmentListService);

        $this->assertInstanceOf(DevelopmentListController::class, $controller);
    }

}