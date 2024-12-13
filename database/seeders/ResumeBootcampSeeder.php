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
        $resumes = Resume::all();

        if ($resumes->isNotEmpty()) {
            $resumes->pop();
        }

        foreach ($resumes as $resume) {
            if (rand(1, 5) !== 1) {
                $selectedBootcamp = $bootcampIds[array_rand($bootcampIds)];
                $this->attachBootcamp($resume, $selectedBootcamp);

                if (rand(1, 4) === 1) {
                    $eligibleBootcamps = array_diff($bootcampIds, [$selectedBootcamp]);
                    if (!empty($eligibleBootcamps)) {
                        $additionalBootcamp = $eligibleBootcamps[array_rand($eligibleBootcamps)]; // Obtener un UUID
                        $this->attachBootcamp($resume, $additionalBootcamp);
                    }
                }
            }
        }
    }

    private function attachBootcamp(Resume $resume, string $bootcampId): void
    {
        $resume->bootcamps()->attach($bootcampId, [
            'end_date' => now()->subYear()->addDays(rand(1, 365))->format('Y-m-d'),
        ]);
    }
}
