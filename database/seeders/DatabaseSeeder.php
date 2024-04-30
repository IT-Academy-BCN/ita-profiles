<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(StudentListSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(AdditionalTrainingSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(ResumeLanguageSeeder::class);
    }
}
