<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Resume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResumeProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resumes = Resume::all();

        foreach ($resumes as $resume) {
            $projects = Project::factory(2)->create();
            $resume->projects()->attach($projects->pluck('id'));
        }
    }
}
