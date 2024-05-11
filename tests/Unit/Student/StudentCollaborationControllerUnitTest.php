<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\StudentCollaborationController;
use App\Service\CollaborationService;

class StudentCollaborationControllerUnitTest extends TestCase
{
    protected $collaborationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collaborationService = new CollaborationService();
    }

    public function testStudentCollaborationControllerCanBeInstantiated(): void
    {
        $controller = new StudentCollaborationController($this->collaborationService);

        $this->assertInstanceOf(StudentCollaborationController::class, $controller);
    }
}
