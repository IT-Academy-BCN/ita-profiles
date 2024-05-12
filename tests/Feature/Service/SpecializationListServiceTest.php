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

        $specializations = ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set'];
        
        foreach ($specializations as $specialization) {
            ResumeFactory::new()->specificSpecialization($specialization)->create();
        }

        $response = $this->getJson(route('roles.list'));

        $response->assertStatus(200);

        $specialization_list= $response->json();
        
        $this->assertCount(4, $specialization_list);
        $this->assertContains('Frontend', $specialization_list);
        $this->assertContains('Backend', $specialization_list);
        $this->assertContains('Fullstack', $specialization_list);
        $this->assertContains('Data Science', $specialization_list);
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
