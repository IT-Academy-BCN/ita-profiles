<?php

namespace Database\Factories;

use App\Models\Collaboration;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollaborationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collaboration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($this->faker->numberBetween(1, 5)),
            'description' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}

