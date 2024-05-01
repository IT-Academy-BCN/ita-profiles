<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\StudentNotFoundException;
use App\Models\Resume;
use App\Models\Student;
use App\Models\Tag;

class StudentDetailsService
{
    public function execute($student)
    {
        return $this->getStudentDetailsById($student);
    }
    

    public function getStudentDetailsById($student){
        
        $studentDetails = Resume::where('student_id', $student)->first();

        if(!$studentDetails){
            throw new StudentNotFoundException($student);
        }

        $studentName = Student::find($studentDetails->student_id); 

        if(!$studentName){
            throw new StudentNotFoundException($student);
        }

        $fullName = $studentName->name . ' ' . $studentName->surname;

        $tagsIds = json_decode($studentDetails->tags_ids, true);
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
            'subtitle' => $studentDetails->subtitle,
                    'social_media' => [
                        'github' => [
                            'url' => $studentDetails->github_url
                        ],
                        'linkedin' => [
                            'url' => $studentDetails->linkedin_url
                        ]
                        
                    ],
            'about' => $studentDetails->about,
            'tags' => $formattedTags,
        ];
        
    }

}
