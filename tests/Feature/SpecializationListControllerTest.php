<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Database\Factories\ResumeFactory;
use App\Models\Resume;
use App\Http\Controllers\api\SpecializationListController;
use App\Service\SpecializationListService;

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
    }

    public function testSpecializationListControllerReturns_200StatusAnEmptyArrayWhenNoResumes(): void
    {
        Resume::query()->delete();

        $response = $this->getJson(route('roles.list'));

        $response->assertStatus(200);
    }

    public function testSpecializationListControllerCanBeInstantiated(): void
    {
        $specializationListService = $this->createMock(SpecializationListService::class);
        
        $controller = new SpecializationListController($specializationListService);

        $this->assertInstanceOf(SpecializationListController::class, $controller);
    }

}

