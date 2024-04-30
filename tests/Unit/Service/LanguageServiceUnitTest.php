<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\Student\LanguageService;
use Tests\TestCase;

class LanguageServiceUnitTest extends TestCase
{
    private $languageService;

    public function setUp(): void
    {
        parent::setUp();

        $this->languageService = new LanguageService();
    }

    public function testLanguageServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(LanguageService::class, $this->languageService);
    }
}