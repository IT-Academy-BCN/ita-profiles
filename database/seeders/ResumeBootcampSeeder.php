<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Bootcamp;
use App\Models\Resume;
use Illuminate\Database\Seeder;

class ResumeBootcampSeeder extends Seeder
{
    public function run(): void
    {
        $bootcampIds = Bootcamp::pluck('id')->toArray();
        $bootcampIds[] = null;

        $resumes = Resume::all();

        foreach ($resumes as $resume) {
            $selectedBootcamp = $bootcampIds[array_rand($bootcampIds)];

            if ($selectedBootcamp !== null) {
                $this->attachBootcamp($resume, $selectedBootcamp);
                $this->attachSecondBootcamp($resume, $bootcampIds, $selectedBootcamp);
            }
        }
    }

    private function attachBootcamp($resume, $selectedBootcamp): void
    {
        $resume->bootcamps()->attach($selectedBootcamp, ['end_date' => now()->subYear()->addDays(rand(1, 365))->format('Y-m-d')]);
    }

    private function attachSecondBootcamp($resume, $bootcampIds, $selectedBootcamp): void
    {
        if (rand(1, 4) === 1 && $selectedBootcamp !== null) {
            $eligibleBootcamps = array_diff($bootcampIds, [$selectedBootcamp, null]);
            if (!empty($eligibleBootcamps)) {
                $additionalBootcamp = $eligibleBootcamps[array_rand($eligibleBootcamps)];
                $this->attachBootcamp($resume, $additionalBootcamp);
            }
        }
    }
}
