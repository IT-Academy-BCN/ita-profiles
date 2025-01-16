<?php

declare(strict_types=1);

namespace Tests\Feature\Service\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Student\SpecializationListService;
use Database\Factories\ResumeFactory;
use App\Models\Resume;

class SpecializationListServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $specializationListService;

    protected function setUp(): void
    {
        parent::setUp();

        Resume::query()->delete();

        $this->specializationListService = new SpecializationListService();
    }

    public function testSpecializationListServiceReturnsAValidSpecializationArrayForExistingResumesWithSpecializationFieldWithValidData(): void
    {
        $specializations = ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set'];

        foreach ($specializations as $specialization) {
            Resume::factory()->create(['specialization' => $specialization]);
        }

        $response = $this->specializationListService->execute();

        $this->assertCount(4, $response);
        $this->assertContains('Frontend', $response);
        $this->assertContains('Backend', $response);
        $this->assertContains('Fullstack', $response);
        $this->assertContains('Data Science', $response);
    }

    public function testSpecializationListServiceReturnsAVoidArrayForExistingResumesWithSpecializationFieldWithNotSetValue(): void
    {
        $specialization = 'Not Set';

        Resume::factory()->count(3)->create(['specialization' => $specialization]);

        $response = $this->specializationListService->execute();

        $this->assertIsArray($response);

        $this->assertEquals([], $response);
    }

    public function testSpecializationListServiceReturnsAnEmptyArrayWhenNoResumes(): void
    {
        $response = $this->specializationListService->execute();

        $this->assertEquals([], $response);
    }

    public function testSpecializationListServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(SpecializationListService::class, $this->specializationListService);
    }
}
