<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Job;

use App\Models\JobOffer;
use Tests\TestCase; 
class JobOfferModelTest extends TestCase
{
    public function testIfJobOfferModelExists(): void
    {
        $this->assertTrue(class_exists(JobOffer::class));
    }
}