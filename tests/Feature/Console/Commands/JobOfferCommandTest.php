<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;


use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\Api\Job\JobOfferController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JobOfferCommandTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected Recruiter $recruiter;

    protected function setUp(): void
    {
        parent::setUp();
        
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $this->recruiter = Recruiter::factory()->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
    }
    
    public function testIfJobOfferModelExists(): void
    {
        $this->assertTrue(class_exists(JobOffer::class));
    }
    public function testIfJobOfferControllerExists(): void
    {
        $this->assertTrue(class_exists(JobOfferController::class));
    }
    public function testCreateJobOfferWithValidParameters()
    {
        $title = $this->faker->jobTitle();
        $description = $this->faker->text();
        $location = $this->faker->city();
        $skills = implode(', ', $this->faker->words(3));
        $salary = $this->faker->numberBetween(20000, 100000);

        $exitCode = Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'skills' => $skills,
            'salary' => $salary
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertDatabaseHas('job_offers', [
            'title' => $title,
            'salary' => $salary,
            'recruiter_id' => $this->recruiter->id,
            'description' => $description,
            'location' => $location,
            'skills' => $skills
        ]);
    }
    public function testCreateJobOfferWithMissingRequiredFields(): void
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);

        Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            // Missing required fields
            'description' => 'Looking for a Junior Developer.'
        ]);
    }
    public function testCreateMultipleJobOffers(): void
    {
        $jobOffers =  JobOffer::factory()
        ->count(5)
        ->create([
            'recruiter_id' => $this->recruiter->id
        ]);
        $this->assertEquals(5, JobOffer::count());
        
        foreach ($jobOffers as $jobOffer) {
            $this->assertDatabaseHas('job_offers', [
                'id' => $jobOffer->id,
                'recruiter_id' => $this->recruiter->id
            ]);
        }
    }
}
