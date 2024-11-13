<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\JobOffer;
use App\Http\Controllers\Api\Job\JobOfferController;

class JobOfferCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIfJobOfferModelExists(): void
    {
        $this->assertTrue(class_exists(JobOffer::class));
    }
    public function testIfJobOfferControllerExists(): void
    {
        $this->assertTrue(class_exists(JobOfferController::class));
    }
    
}
