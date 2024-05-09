<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\Student\StudentProjectsDetailService;
use Tests\TestCase;

class StudentProjectsDetailServiceUnitTest extends TestCase{
    private $StudentProjectsDetailService;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->StudentProjectsDetailService = new StudentProjectsDetailService();
    }

    public function testStudentProjectsDetailServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(StudentProjectsDetailService::class, $this->StudentProjectsDetailService);
        
    }
    
}