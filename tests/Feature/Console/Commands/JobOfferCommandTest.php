<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;


use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use App\Console\Commands\CreateJobOfferCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
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
    public function testCreateJobOfferWithAllArgumentsProvided(): void
    {
        $title = $this->faker->jobTitle();
        $description = $this->faker->text();
        $location = $this->faker->city();
        $skills = implode(', ', $this->faker->words(3));
        $salary = $this->faker->numberBetween(20000, 100000);

        $this->artisan('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'salary' => $salary,
            'skills' => $skills
        ])
        ->expectsOutput("Detalls de l'oferta:")
        ->assertExitCode(0);

        $this->assertDatabaseHas('job_offers', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'salary' => $salary,
            'skills' => $skills
        ]);
    }
    public function testCreateJobOfferWithValidParameters()
    {
        $title = $this->faker->jobTitle();
        $description = $this->faker->text();
        $location = $this->faker->city();
        $skills = implode(', ', $this->faker->words(3));
        $salary = $this->faker->numberBetween(20000, 100000);
    
        $this->artisan('job:offer:create')
            ->expectsQuestion('Introdueix l\'ID del reclutador', $this->recruiter->id)
            ->expectsQuestion('Introdueix el títol de l\'oferta', $title)
            ->expectsQuestion('Introdueix la descripció de l\'oferta', $description)
            ->expectsQuestion('Introdueix la ubicació', $location)
            ->expectsQuestion('Introdueix el salari', $salary)
            ->expectsQuestion('Introdueix les habilitats requerides (opcional, separades per comes)', $skills)
            ->expectsOutput("Detalls de l'oferta:")
            ->assertExitCode(0);
    
        $this->assertDatabaseHas('job_offers', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $title,
            'description' => $description,
            'location' => $location,
            'salary' => $salary,
            'skills' => $skills
        ]);
    }
   
    /* Unupdated tests:
  
    public function testCreateJobOfferWithMissingRequiredFields(): void
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);

        Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'description' => 'Looking for a Junior Developer.'
        ]);
    }
    public function testCreateMultipleJobOffers(): void
    {
        $initialCount = JobOffer::where('recruiter_id', $this->recruiter->id)->count();

        $jobOffers =  JobOffer::factory()
            ->count(5)
            ->create([
                'recruiter_id' => $this->recruiter->id
            ]);
        $this->assertEquals($initialCount + 5, JobOffer::where('recruiter_id', $this->recruiter->id)->count());

        foreach ($jobOffers as $jobOffer) {
            $this->assertDatabaseHas('job_offers', [
                'id' => $jobOffer->id,
                'recruiter_id' => $this->recruiter->id
            ]);
        }
    }
    public function testCreateJobOfferWithInvalidRecruiterId(): void
    {
        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);

        Artisan::call('job:offer:create', [
            'recruiter_id' => 0,
            'title' => 'Software Engineer',
            'description' => 'Looking for a Junior Developer.'
        ]);
    }
    public function testCreateJobOfferWithInvalidSkills(): void
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'location' => $this->faker->city(),
            'skills' => ['PHP', 'Laravel', 'MySQL'],
            'salary' => 50000
        ]);
    }
    public function testCreateJobOfferCommandWithTooLongDescription(): void
    {
        $longDescription = str_repeat('a', 1000);

        $exitCode = Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $this->faker->jobTitle(),
            'description' => $longDescription,
            'location' => $this->faker->city(),
            'skills' => 'PHP, Laravel, MySQL',
            'salary' => 50000
        ]);

        $this->assertEquals(0, $exitCode);
        $this->assertDatabaseHas('job_offers', [
            'description' => $longDescription,
            'recruiter_id' => $this->recruiter->id
        ]);
    }
    public function testJobOfferCreateCommandEnsuresSalaryIsPositive(): void
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        Artisan::call('job:offer:create', [
            'recruiter_id' => $this->recruiter->id,
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'location' => $this->faker->city(),
            'skills' => 'PHP, Laravel, MySQL',
            'salary' => -5000
        ]);
    }
        */
}
