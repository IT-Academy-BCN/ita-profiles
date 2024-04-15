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
        $bootcamps = Bootcamp::all();
        $resumes = Resume::all();

        $resumes->each(function ($resume) use ($bootcamps) {
            $randomBootcamp = $bootcamps->random();
            $resume->bootcamps()->attach(
                $randomBootcamp->id,
                ['end_date' => now()->subYear()->addDays(rand(1, 365))->format('Y-m-d')],
            );
        });
    }
}
