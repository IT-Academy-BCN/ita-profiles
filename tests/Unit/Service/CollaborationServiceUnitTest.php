<?php

declare(strict_types=1);

namespace tests\Unit\Service;

use App\Service\CollaborationService;
use Tests\TestCase;

class CollaborationServiceUnitTest extends TestCase
{
    private $collaborationService;

    public function setUp(): void
    {
        parent::setUp();

        $this->collaborationService = new CollaborationService();
    }

    public function testCollaborationServiceCanBeInstantiated(): void
    {
        self::assertInstanceOf(CollaborationService::class, $this->collaborationService);
    }
}
