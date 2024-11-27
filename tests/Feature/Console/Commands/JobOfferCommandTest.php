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

        $this->artisan('create:job-offer', [
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
    
        $this->artisan('create:job-offer')
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
  
public function testCreateMultipleJobOffers(): void
{
    $initialCount = JobOffer::where('recruiter_id', $this->recruiter->id)->count();

    $jobOffers = JobOffer::factory()
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
public function testJobOfferCanBeCreatedViaCommand(): void
{
    $this->artisan('create:job-offer')
        ->expectsQuestion('Introdueix l\'ID del reclutador', $this->recruiter->id)
        ->expectsQuestion('Introdueix el títol de l\'oferta', 'Test Job')
        ->expectsQuestion('Introdueix la descripció de l\'oferta', 'Test Description')
        ->expectsQuestion('Introdueix la ubicació', 'Test Location')
        ->expectsQuestion('Introdueix el salari', '50000')
        ->expectsQuestion('Introdueix les habilitats requerides (opcional, separades per comes)', '')
        ->assertExitCode(0);

    $this->assertDatabaseHas('job_offers', [
        'recruiter_id' => $this->recruiter->id,
        'title' => 'Test Job',
        'description' => 'Test Description',
        'location' => 'Test Location',
        'salary' => 50000,
    ]);
}

/**
 * @dataProvider invalidDataProvider
 */
public function testReturnsErrorCodeOnInvalidData($invalidData): void
{
    $this->artisan('create:job-offer')
        ->expectsQuestion('Introdueix l\'ID del reclutador', $this->recruiter->id)
        ->expectsQuestion('Introdueix el títol de l\'oferta', $invalidData['title'])
        ->expectsQuestion('Introdueix la descripció de l\'oferta', $invalidData['description'])
        ->expectsQuestion('Introdueix la ubicació', $invalidData['location'])
        ->expectsQuestion('Introdueix el salari', $invalidData['salary'])
        ->expectsQuestion('Introdueix les habilitats requerides (opcional, separades per comes)', '')
        ->assertExitCode(1);
}

public static function invalidDataProvider(): array
{
    return [
        // Invalid title
        'invalid title: too long' => [[
            'title' => str_repeat('A', 256),
            'description' => 'Valid Description',
            'location' => 'Valid Location',
            'salary' => '50000',
        ]],
        'invalid title: empty' => [[
            'title' => '',
            'description' => 'Valid Description',
            'location' => 'Valid Location',
            'salary' => '50000',
        ]],
        // Invalid description
        'invalid description: too short' => [[
            'title' => 'Valid Job',
            'description' => 'Too',
            'location' => 'Valid Location',
            'salary' => '50000',
        ]],
        'invalid description: empty' => [[
            'title' => 'Valid Job',
            'description' => '',
            'location' => 'Valid Location',
            'salary' => '50000',
        ]],
        // Invalid location
        'invalid location: empty' => [[
            'title' => 'Valid Job',
            'description' => 'Valid Description',
            'location' => '',
            'salary' => '50000',
        ]],
        'invalid location: too long' => [[
            'title' => 'Valid Job',
            'description' => 'Valid Description',
            'location' => str_repeat('L', 256),
            'salary' => '50000',
        ]],
        // Invalid salary
        'invalid salary: not a number' => [[
            'title' => 'Valid Job',
            'description' => 'Valid Description',
            'location' => 'Valid Location',
            'salary' => 'NotANumber',
        ]],
        'invalid salary: negative' => [[
            'title' => 'Valid Job',
            'description' => 'Valid Description',
            'location' => 'Valid Location',
            'salary' => '-1000',
        ]],
        'invalid salary: empty' => [[
            'title' => 'Valid Job',
            'description' => 'Valid Description',
            'location' => 'Valid Location',
            'salary' => '',
        ]],
    ];
}
}
