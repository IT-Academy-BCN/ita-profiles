<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Api\Job\JobOfferController;

class CreateJobOfferCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'joboffer:create
                            {recruiter_id : The ID of the recruiter}
                            {title : The title of the job offer}
                            {description : The description of the job offer}
                            {location : The location of the job offer}
                            {salary : The salary offered for the job offer}
                            {skills? : The skills required for the job offer}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new job offer via the console';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
            'recruiter_id' => $this->argument('recruiter_id'),
            'title' => $this->argument('title'),
            'description' => $this->argument('description'),
            'location' => $this->argument('location'),
            'skills' => $this->argument('skills') ?? null,
            'salary' => $this->argument('salary'),
        ];

        // Invoke the controller and pass the data
        $controller = new JobOfferController();
        $response = $controller->createJobOffer((object) $data); 

        // Show result message
        $jobOffer = $response->getData()->jobOffer;
        $this->info("Oferta de feina creada amb èxit: " . json_encode($jobOffer));
    }
}
