<?php

namespace Database\Factories;

use App\Models\Recruiter;
use App\Models\Company; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOffer>
 */
class JobOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $company = Company::inRandomOrder()->first();
        
        if (!$company) {
            $company = Company::factory()->create(); 
        }

        return [
            'recruiter_id' => Recruiter::inRandomOrder()->first()->id,
            'company_id' => $company->id,
            'title' => $faker->jobTitle(),
            'description' => $faker->text(),
            'location' => $faker->city(),
            'salary' => $faker->numberBetween(1000, 3000)
        ];
    }
}
