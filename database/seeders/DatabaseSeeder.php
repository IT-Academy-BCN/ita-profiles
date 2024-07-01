<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(StudentListSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(AdditionalTrainingSeeder::class);
        $this->call(CollaborationSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(ResumeLanguageSeeder::class);
        $this->call(BootcampSeeder::class);
        $this->call(ResumeBootcampSeeder::class);
        $this->call(SigninTestSeeder::class);
    }
}
