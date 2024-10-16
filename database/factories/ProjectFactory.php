<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tag;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'company_name' => $this->faker->company,
            'github_url' => $this->faker->parse('https://github.com/') . $this->faker->userName,
            'project_url' => $this->faker->url,
            'github_repository_id' => null,
        ];
    }
}
