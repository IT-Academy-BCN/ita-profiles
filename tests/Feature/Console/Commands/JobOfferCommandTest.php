<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\Recruiter;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\api\Job\JobOfferController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Unit\Model\Job\JobOfferModelTest; 
use Tests\Feature\Controller\Job\JobOfferControllerTest;

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
        $jobOfferModel = new JobOffer();
    
        $this->assertInstanceOf(JobOffer::class, $jobOfferModel);
    }
    
    public function testIfJobOfferControllerExists(): void
    {
        $jobOfferController = new JobOfferController();
    
        $this->assertInstanceOf(JobOfferController::class, $jobOfferController);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testInvalidJobOffer($invalidData): void
    {
        $maxAttempts = 3; 
        $exceptionThrown = false;

        for ($attempts = 0; $attempts < $maxAttempts; $attempts++) {
            try {
                $this->artisan('create:job-offer')
                    ->expectsQuestion('Introdueix l\'ID del reclutador', $this->recruiter->id)
                    ->expectsQuestion('Introdueix el títol de l\'oferta', $invalidData['title'])
                    ->expectsQuestion('Introdueix la descripció de l\'oferta', $invalidData['description'])
                    ->expectsQuestion('Introdueix la ubicació', $invalidData['location'])
                    ->expectsQuestion('Introdueix el salari', $invalidData['salary'] ?? '')
                    ->expectsQuestion('Introdueix les habilitats requerides (opcional, separades per comes)', '')
                    ->assertExitCode(1);
                
                
                $this->fail('Expected an exception to be thrown for invalid data: ' . json_encode($invalidData));
            } catch (\Exception $e) {
                
                $exceptionThrown = true;
                break;
            }
        }

        $this->assertTrue($exceptionThrown, 'No se lanzó la excepción esperada para datos inválidos');
    }

    public static function invalidDataProvider(): array
    {
        return [
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
            'invalid description: too long' => [[
                'title' => 'Valid Job',
                'description' => str_repeat('A', 256),
                'location' => 'Valid Location',
                'salary' => '50000',
            ]],
            'invalid description: empty' => [[
                'title' => 'Valid Job',
                'description' => '',
                'location' => 'Valid Location',
                'salary' => '50000',
            ]],
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
            'invalid salary: too long' => [[
                'title' => 'Valid Job',
                'description' => 'Valid Description',
                'location' => 'Valid Location',
                'salary' => str_repeat('1', 256),
            ]],
            'invalid skills: too long' => [[
                'title' => 'Valid Job',
                'description' => 'Valid Description',
                'location' => 'Valid Location',
                'salary' => '50000',
                'skills' => str_repeat('Skill, ', 50),
            ]],
        ];
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

  
}
