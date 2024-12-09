<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\Collaboration;
use Illuminate\Database\Seeder;

class StudentListSeeder extends Seeder
{
    public function run(): void
    {

        $resumes = Resume::factory()->count(30)->create();

        foreach($resumes as $resume){
            $collaborations = Collaboration::factory()->count(2)->create();
            $resume->collaborations()->attach($collaborations->pluck('id'));
		}
    }
}
