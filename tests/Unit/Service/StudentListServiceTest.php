<?php

declare(strict_types=1);

namespace Service;

use App\Models\Resume;
use App\Service\StudentListService;
use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class StudentListServiceTest extends TestCase
{


    private $resumeUpdateService;
    private $studentListService;

    public function setUp(): void
    {
        parent::setUp();

        $this->resumeUpdateService = new StudentListService();
        $this->studentListService = new StudentListService();

        $this->artisan('migrate:fresh --seed');
        $this->artisan('passport:install');
    }

    public function testCanInstantiate(): void
    {
        self::assertInstanceOf(StudentListService::class, $this->resumeUpdateService);
        self::assertInstanceOf(StudentListService::class, $this->studentListService);
    }
}
