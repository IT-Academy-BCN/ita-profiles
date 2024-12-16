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

class CreateJobOfferByCommandTest extends TestCase
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

    public function testCreateJobOfferViaCommand(): void
    {
        $this->artisan('create:job-offer')
            ->expectsQuestion('Enter the recruiter ID', $this->recruiter->id)  // Asegúrate de que esta pregunta y respuesta se estén esperando bien
            ->expectsQuestion('Enter the job offer title (e.g., Senior Frontend Developer)' . "\n(or type 'cancel' to exit)", 'Junior Backend Developer')
            ->expectsQuestion('Enter the job offer description (e.g., Seeking a creative developer.)' . "\n(or type 'cancel' to exit)", 'We are looking for a junior developer')
            ->expectsQuestion('Enter the job offer location (e.g., Barcelona)' . "\n(or type 'cancel' to exit)", 'Barcelona')
            ->expectsQuestion('Enter the job offer salary (optional, e.g., 25000 - 35000)' . "\n(or type 'cancel' to exit)", '30000')
            ->expectsQuestion('Enter the required skills (optional, separated by commas or "cancel")', 'PHP, Laravel')
            ->expectsConfirmation('Do you want to proceed with these details?', 'yes')
            ->assertExitCode(0);

            $this->assertDatabaseHas('job_offers', [
                'recruiter_id' => $this->recruiter->id,
                'company_id' => $this->recruiter->company_id,
                'title' => 'Junior Backend Developer',
                'description' => 'We are looking for a junior developer',
                'location' => 'Barcelona',
                'salary' => '30000',
                'skills' => 'PHP, Laravel'
            ]);
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
                    ->expectsQuestion('Enter the recruiter ID', $this->recruiter->id)
                    ->expectsQuestion('Enter the job offer title', $invalidData['title'])
                    ->expectsQuestion('Enter the job offer description', $invalidData['description'])
                    ->expectsQuestion('Enter the location', $invalidData['location'])
                    ->expectsQuestion('Enter the salary', $invalidData['salary'] ?? '')
                    ->expectsQuestion('Enter the required skills (optional, separated by commas)', '')
                    ->assertExitCode(1);


                $this->fail('The expected exception was not thrown for invalid data: ' . json_encode($invalidData));
            } catch (\Exception $e) {

                $exceptionThrown = true;
                break;
            }
        }

        $this->assertTrue($exceptionThrown, 'The expected exception was not thrown for invalid data.');
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
