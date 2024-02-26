<?php

namespace Database\Seeders;

use App\Models\Resume;
use Illuminate\Database\Seeder;

class StudentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {
        $resumes =  Resume::factory()->count(30)->create();
        // $resumes->map(function ($resume) {
        //      $resume->student->user->assignRole('student');
        // });

    }




}
