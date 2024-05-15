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

        $response = $this->specializationListService->execute(); // DEBERÍA SER LA LLAMADA AL SERVICE

        $this->assertCount(4, $response);
        $this->assertContains('Frontend', $response);
        $this->assertContains('Backend', $response);
        $this->assertContains('Fullstack', $response);
        $this->assertContains('Data Science', $response);
    }

    public function testSpecializationListServiceReturnsAVoidArrayForExistingResumesWithSpecializationFieldWithNotSetValue(): void
    {
        Resume::query()->delete();

        $specialization = 'Not Set';
    
        for ($i = 0; $i < 3; $i++) {
            ResumeFactory::new()->specificSpecialization($specialization)->create();
        }
        
        $response = $this->specializationListService->execute();

        $this->assertIsArray($response);
        
        $this->assertEquals([], $response);
    }

    public function testSpecializationListServiceReturnsAnEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->specializationListService->execute();

        $this->assertEquals([], $response);
    }
}
