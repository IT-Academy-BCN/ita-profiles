<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resume;
use App\Models\AdditionalTraining;

class ResumeAdditionalTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $resumes = Resume::all();
        $additionalTrainings = AdditionalTraining::all();

        // Attach random additional_trainings (between 0 and 3) to each existing resume
        $resumes->each(function ($resume) use ($additionalTrainings) {            
            $resume->additionalTrainings()->attach(
                $additionalTrainings->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}