<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use App\Models\Recruiter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recruiter>
 */
class RecruiterFactory extends Factory
{
    protected $model = Recruiter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Ensure the User and Company exist or create them on the fly
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
            'role_id' => 2,
        ];
    }
}
