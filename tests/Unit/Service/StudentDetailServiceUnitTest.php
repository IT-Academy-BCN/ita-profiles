<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\StudentDetailService;
use Tests\TestCase;

class StudentDetailServiceUnitTest extends TestCase
{
    private $studentDetailService;

    public function setUp(): void
    {
        parent::setUp();

        $this->studentDetailService = new StudentDetailService();
    }

    public function testStudentDetailServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentDetailService::class, $this->studentDetailService);
    }
}
