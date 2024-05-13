<?php

declare(strict_types=1);

namespace App\Service;

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
        
        Resume::where('student_id', $studentId)->first();
        $student = Student::find($studentId);

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        $resume = $student->resume()->first();

        if (!$resume) {
            throw new ResumeNotFoundException($studentId);
        }

        $fullName = $student->name . ' ' . $student->surname;

        $tagsIds = json_decode($resume->tags_ids, true);
        $tags = Tag::whereIn('id', $tagsIds)->get(['id', 'tag_name'])->toArray();

        $formattedTags = [];
        foreach ($tags as $tag) {
            $formattedTags[] = [
                'id' => $tag['id'],
                'name' => $tag['tag_name']
            ];
        }

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

}
