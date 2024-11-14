<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // TODO: This should use the nomenclature of linguist library (https://github.com/github-linguist/linguist/blob/master/lib/linguist/languages.yml)
    protected $tagNames = [
        "PHP", "Laravel", "Blade","JavaScript",
        "React","Vue","HTML", "CSS",
        "MongoDB","SQL","Tailwind",
        "Bootstrap", "JQuery", "Angular",
        "Nodejs","Express", "Java",
        "Python", "C","C++",
        "C#","Ruby","Spring Boot",
        "Ruby on Rails","Django","Redis",
        "Git","GitHub",
    ];
    public function definition(): array
    {
        return [
        'name' => $this->faker->unique()->randomElement($this->tagNames),
    ];
    }


}
