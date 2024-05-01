<?php

declare(strict_types=1);

namespace Tests\Unit\Student;

use Tests\TestCase;
use App\Http\Controllers\Api\StudentLanguagesDetailController;
use App\Service\Student\LanguageService;

class StudentLanguagesDetailControllerUnitTest extends TestCase
{
    protected $languageService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->languageService = new languageService();
    }

    public function testStudentLanguagesDetailControllerCanBeInstantiated()
    {

        $controller = new StudentLanguagesDetailController($this->languageService);

        $this->assertInstanceOf(StudentLanguagesDetailController::class, $controller);
    }
}
