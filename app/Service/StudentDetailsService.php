<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;

class StudentDetailsService
{
    public function execute($student)
    {
        return $this->getStudentDetailsById($student);
    }
    

    public function getStudentDetailsById($studentId){
        
        $resume = Resume::where('student_id', $studentId)->first();

        if(!$resume){
            throw new ResumeNotFoundException($studentId);
        }

        $student = Student::find($resume->student_id); 

        if(!$student){
            throw new StudentNotFoundException($studentId);
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
