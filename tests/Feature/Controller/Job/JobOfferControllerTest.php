<?php

declare(strict_types=1);

namespace Tests\Feature\Controller\Job;

use Tests\TestCase;
use App\Http\Controllers\api\Job\JobOfferController;


class JobOfferControllerTest extends TestCase
{
    public function testIfJobOfferControllerExists(): void
    {
        $this->assertTrue(class_exists(JobOfferController::class));
    }
}