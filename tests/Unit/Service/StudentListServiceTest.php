<?php

declare(strict_types=1);

namespace Service;

use App\Service\StudentListService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StudentListServiceTest extends TestCase
{

    private $resumeUpdateService;
    private $studentListService;

    public function setUp(): void
    {
        parent::setUp();

        $this->resumeUpdateService = new StudentListService();
        $this->studentListService = new StudentListService();
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(StudentListService::class, $this->resumeUpdateService);
        self::assertInstanceOf(StudentListService::class, $this->studentListService);
    }
}
