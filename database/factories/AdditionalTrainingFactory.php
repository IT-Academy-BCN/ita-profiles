<?php

namespace Database\Factories;

use App\Models\AdditionalTraining;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalTrainingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdditionalTraining::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currentYear = date('Y');
        
        $beginningYear = $this->faker->numberBetween(2000, $currentYear - 1);

        $endingYear = $this->faker->numberBetween($beginningYear, $currentYear);

        return [
            'course_name' => $this->faker->sentence(3),
            'study_center' => $this->faker->company,
            'course_beginning_year' => $beginningYear,
            'course_ending_year' => $endingYear,
            'duration_hrs' => $this->faker->numberBetween(60, 500),
        ];
    }
}
