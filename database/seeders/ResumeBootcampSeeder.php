<?php

namespace Database\Seeders;

use App\Models\Bootcamp;
use App\Models\Resume;
use Illuminate\Database\Seeder;

class ResumeBootcampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bootcamps = Bootcamp::all()->pluck('id')->toArray();
        $bootcamps[] = null;

        $resumes = Resume::all();

        foreach ($resumes as $resume) {
            $selectedBootcamp = $bootcamps[array_rand($bootcamps)];

            if ($selectedBootcamp !== null) {
                $resume->bootcamps()->attach(
                    $selectedBootcamp,
                    ['end_date' => now()->subYear()->addDays(rand(1, 365))->format('Y-m-d')],
                );
            }
            // Add ramdomly a second bootcamp with a 25% probability.
            if (!rand(0, 3)) {
                $eligibleBootcamps = array_diff($bootcamps, [$selectedBootcamp, null]);
                if (!empty($eligibleBootcamps)) {
                    $additionalBootcamp = $eligibleBootcamps[array_rand($eligibleBootcamps)];
                    $resume->bootcamps()->attach(
                        $additionalBootcamp,
                        ['end_date' => now()->subYear()->addDays(rand(1, 365))->format('Y-m-d')],
                    );
                }
            }
        }
    }
}
