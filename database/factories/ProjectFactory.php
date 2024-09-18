<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tag;

class ProjectFactory extends Factory
{
    
    private function getTagObjects(): array
    {
        $tagIds = Tag::inRandomOrder()->limit($this->faker->numberBetween(2, 5))->pluck('id')->toArray();
        
        return $tagIds;
    }

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'company_name' => $this->faker->company,
            'tags' => json_encode($this->getTagObjects()),
            'github_url' => $this->faker->parse('https://github.com/') . $this->faker->userName,
            'project_url' => $this->faker->url,
        ];
    }
}
