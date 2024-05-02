<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\Resume\StudentProjectsDetailService;
use Tests\TestCase;

class StudentProjectsDetailServiceTest extends TestCase{
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