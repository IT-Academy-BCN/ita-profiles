<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdditionalTraining;

class AdditionalTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdditionalTraining::factory()->count(30)->create();
    }
}
