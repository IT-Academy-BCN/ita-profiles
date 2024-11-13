<?php

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
    public function test_job_offer_model_exists(): void
    {
        // Check if the JobOffer model exists
        $this->assertTrue(class_exists(JobOffer::class));
    }
    public function test_job_offer_controller_exists(): void
    {
        // Check if the JobOfferController exists
        $this->assertTrue(class_exists(JobOfferController::class));
    }
}
