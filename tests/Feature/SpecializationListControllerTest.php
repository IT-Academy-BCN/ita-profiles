<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Database\Factories\ResumeFactory;
use App\Models\Resume;

class SpecializationListControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testSpecializationListControllerReturns_200StatusAndValidSpecializationListForResumesWithValidSpecializations(): void
    {
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

    public function testSpecializationListControllerReturns_200StatusAnEmptyArrayForResumesWithNotSetSpecialization(): void
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

    public function testSpecializationListControllerReturns_200StatusAnEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->getJson(route('roles.list'));

        $response->assertStatus(200);

        $specialization_list = $response->json();

        $this->assertEquals([], $specialization_list);
    }

}

