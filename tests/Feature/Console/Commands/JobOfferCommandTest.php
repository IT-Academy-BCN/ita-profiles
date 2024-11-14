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
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\Job\JobOfferController;

class JobOfferCommandTest extends TestCase
{
    protected User $user;
    protected Company $company;
    protected Recruiter $recruiter;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup base test data
        $this->user = User::factory()->create();
        
        $this->company = Company::create([
            'name' => 'Test Company',
            'location' => 'Test Location',
            'email' => 'company' . uniqid() . '@example.com',
            'CIF' => 'A' . uniqid(),
            'website' => 'https://company.com',
        ]);

        $this->recruiter = Recruiter::create([
            'company_id' => $this->company->id,
            'user_id' => $this->user->id,
            'name' => 'Recruiter Name',
            'email' => 'recruiter@example.com',
            'role' => 'Recruiter',
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
        $exitCode = Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'title' => 'Software Engineer',
            'description' => 'Looking for a Software Engineer.',
            'location' => 'Remote',
            'skills' => 'PHP, Laravel, JavaScript',
            'salary' => 25000
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertDatabaseHas('job_offers', [
            'title' => 'Software Engineer',
            'salary' => 25000,
            'recruiter_id' => $this->recruiter->id,
            'description' => 'Looking for a Software Engineer.',
            'location' => 'Remote',
            'skills' => 'PHP, Laravel, JavaScript'
        ]);
    }
}
