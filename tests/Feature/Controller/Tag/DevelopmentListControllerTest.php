<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Database\Factories\ResumeFactory;
use App\Models\Resume;
use App\Http\Controllers\api\Tag\DevelopmentListController;


class DevelopmentListControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testDevelopmentListControllerReturns_200StatusAndValidDevelopmentListForResumesWithValidDevelopmentOptions(): void
    {
        $developmentOptions = ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'];

        foreach ($developmentOptions as $development) {
            Resume::factory()->create(['development' => $development]);
        }

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

        $response->assertJsonMissing([
            'development' => 'Not Set',
        ]);

        
        
    }

    public function testDevelopmentListControllerReturns_200StatusAndEmptyArrayForResumesWithNotSetDevelopmentOption(): void
    {
        Resume::query()->delete();

        $development = 'Not Set';

        Resume::factory()->count(3)->state(['development' => $development])->create();

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

    }

  public function testDevelopmentListControllerReturns_200StatusAndEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->getJson(route('development.list'));

        $response->assertStatus(200);

    }

    
    

}
