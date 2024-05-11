<?php

declare(strict_types=1);

namespace Tests\Feature\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\SpecializationListService;
use Database\Factories\ResumeFactory;
use App\Models\Resume;

class SpecializationListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $specializationListService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->specializationListService = new SpecializationListService();
    }

    public function testSpecializationListServiceReturnsAValidSpecializationArrayForExistingResumesWithSpecializationFieldWithValidData(): void
    {
        Resume::query()->delete();

        $specialization = 'Not Set';
    
        for ($i = 0; $i < 3; $i++) {
            ResumeFactory::new()->specificSpecialization($specialization)->create();
        }

        $response = $this->getJson(route('roles.list'));

        $response->assertStatus(200);

        $specialization_list= $response->json();

        $this->assertIsArray($specialization_list);
        
        $this->assertEquals([], $specialization_list);
    }

    public function testSpecializationListServiceReturnsAVoidArrayForExistingResumesWithSpecializationFieldWithNotSetValue(): void
    {
        Resume::query()->delete();

        $specialization = 'Not Set';
    
        for ($i = 0; $i < 3; $i++) {
            ResumeFactory::new()->specificSpecialization($specialization)->create();
        }

        $response = $this->getJson(route('roles.list'));

        $response->assertStatus(200);

        $specialization_list= $response->json();

        $this->assertIsArray($specialization_list);
        
        $this->assertEquals([], $specialization_list);
    }

    public function testSpecializationListServiceReturnsAnEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->getJson(route('roles.list'));

        $response->assertStatus(200);

        $specialization_list = $response->json();

        $this->assertEquals([], $specialization_list);
    }
}
