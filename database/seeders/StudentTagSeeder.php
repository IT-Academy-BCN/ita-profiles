<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class StudentTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();
        $students = Student::all();

        foreach ($students as $student) {
            $assignedTags = [];
            $assignedTags = $this->assignTagsToStudent($tags, $assignedTags);

            $student->tags()->attach($assignedTags);
        }
    }
    public function assignTagsToStudent(Collection $tags, array $assignedTags): array
    {
        while (count($assignedTags) < rand(2, 5)) {
            $tag = $tags->random();

            if (!in_array($tag->id, $assignedTags)) {
                $assignedTags[] = $tag->id;
            }
        }

        return $assignedTags;
    }
}
