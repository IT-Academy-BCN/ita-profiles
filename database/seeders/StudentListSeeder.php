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

        $resumes->first()->update([
            'github_url' => 'https://github.com/IT-Academy-BCN',
        ]);

        $firstUser = $resumes->first()->student->user;
        if ($firstUser) {
            $firstUser->update([
                'dni' => '48332312C',
                'password' => 'passOnePass',
            ]);
        }

        $secondUser = $resumes->skip(1)->first()->student->user;
        if ($secondUser) {
            $secondUser->update([
                'dni' => 'Y4527507V',
                'password' => 'passOnePass',
            ]);
        }

        $collaborations = Collaboration::factory()->count($resumes->count() * 2)->create();

        $resumes->each(function ($resume) use ($collaborations) {
            $resume->collaborations()->sync($collaborations->random(2)->pluck('id')->toArray());
        });
    }
}
