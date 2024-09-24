<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Student;
use App\Models\AdditionalTraining;
use App\Models\Collaboration;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Cache;

class ResumeFactory extends Factory
{
    public const  SUBTITLES = [
        "Ingeniero de Software",
        "Full Stack developer en PHP",
        "Frontend developer React",
        "Backend developer Java",
        "Analista de Datos",
    ];

    public function definition(): array
    {
        $developmentOptions = ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'];
        $development = $this->faker->randomElement($developmentOptions);

        $tagIds = Tag::pluck('id')->toArray();
        $randomTagIds = $this->getRandomUniqueElements($tagIds, 4);
        $tagsIds = json_encode($randomTagIds);

        $additionalTrainingsIds = AdditionalTraining::factory()->count(2)->create()->pluck('id')->toArray();
        $collaborationsIds = Collaboration::factory()->count(2)->create()->pluck('id')->toArray();

        // TEMPORARY: This is used to create add the two users to the first two students.
        static $studentIndex = 0; // Keep track of the number of students created
        $userIds = Cache::get('test_user_ids', []);
        // Assign a user ID to the first students, then default to null
        $userId = ($studentIndex < count($userIds)) ? $userIds[$studentIndex] : null;
        $studentIndex++; // Increment the index for each student created

        return [
            'student_id' => Student::factory()->create([
                'user_id' => $userId, // This will be null after the first two students
            ])->id,
            'subtitle' => $this->faker->randomElement(self::SUBTITLES),
            'linkedin_url' => $this->faker->parse('https://linkedin.com/') . $this->faker->userName,
            'github_url' => $this->faker->parse('https://github.com/') . $this->faker->userName,
            'tags_ids' => $tagsIds,
            'specialization' => $this->faker->randomElement(
                ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set'],
            ),
            'development' => $development,
            'about' => $this->faker->paragraph,
            'modality' => $this->faker->randomElements(['Presencial', 'Híbrid', 'Remot'], rand(1, 3)),          
            'collaborations_ids' => json_encode($collaborationsIds),
        ];
    }

    /**
     * Get random unique elements from an array.
     *
     * @param array $array The array from which to select elements.
     * @param int $count The number of elements to select.
     * @return array An array of randomly selected unique elements.
     */
    private function getRandomUniqueElements(array $array, int $count): array
    {
        if (empty($array) || $count <= 0) {  // Returns empty array if $array is empty or $count is less than or equal to 0
            return [];
        }
        
        $keys = array_rand($array, $count); // Randomly select keys from the array
        if (!is_array($keys)) {
            $keys = [$keys];
             // Ensure $keys is an array
        }
        $randomElements = array_intersect_key($array, array_flip($keys)); // Fetch elements from $array based on $keys
        return array_values($randomElements); // Return values as indexed array
    }

    public function specificSpecialization(string $specialization): Factory
    {
        return $this->state(function (array $attributes) use ($specialization) {
            return [
                'specialization' => $specialization,
            ];
        });
    }

    public function specificDevelopment($data): Factory
    {
        return $this->state(function (array $attributes) use ($data) {
            return [
                'development' => $data,
            ];
        });
    }
}
