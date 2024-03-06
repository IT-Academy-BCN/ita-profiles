<?php

declare(strict_types=1);

namespace Service;

use App\Models\Resume;
use App\Service\StudentListService;
use Tests\TestCase;

class StudentListServiceTest extends TestCase
{
    private $resumeUpdateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->resumeUpdateService = new StudentListService();
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(StudentListService::class, $this->resumeUpdateService);
    }

    public function testExecuteStudentListService(): void
    {
        Resume::factory()->count(10)->create();
        $data = $this->resumeUpdateService->execute();
        self::assertCount(10, $data);

    }

}
