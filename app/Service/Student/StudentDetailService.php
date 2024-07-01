<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;

class StudentDetailService
{
    public function execute(string $studentId): array
    {
        return $this->getStudentDetailsById($studentId);
    }
    

    public function getStudentDetailsById($studentId): array
    {
        $student = $this->getStudent($studentId);
        $resume = $this->getResume($student);
        $fullName = $this->getFullName($student);
        $formattedTags = $this->getFormattedTags($resume);

        return [
            'fullname' => $fullName,
            'subtitle' => $resume->subtitle,
            'social_media' => [
                'github' => [
                    'url' => $resume->github_url
                ],
                'linkedin' => [
                    'url' => $resume->linkedin_url
                ]
            ],
            'about' => $resume->about,
            'tags' => $formattedTags,
        ];
    }

    private function getStudent($studentId): Student
    {
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        return $student;
    }

    private function getResume(Student $student): Resume
    {
        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($student->id);
        }

        return $resume;
    }

    private function getFullName(Student $student): string
    {
        return $student->name . ' ' . $student->surname;
    }

    private function getFormattedTags(Resume $resume): array
    {
        $tagsIds = json_decode($resume->tags_ids, true);
        $tags = Tag::whereIn('id', $tagsIds)->get(['id', 'tag_name'])->toArray();

        $formattedTags = [];
        foreach ($tags as $tag) {
            $formattedTags[] = [
                'id' => $tag['id'],
                'name' => $tag['tag_name']
            ];
        }

        return $formattedTags;
    }
}
