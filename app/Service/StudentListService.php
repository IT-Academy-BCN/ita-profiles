<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Resume;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentListService
{


    public function execute(?string $specialization = null): array
{
    if ($specialization) {
        $resumes = Resume::where('specialization', $specialization )->get();
    } else {
        $resumes = Resume::all();
    }

    if($resumes->isEmpty()) {
        throw new ModelNotFoundException(__('No hi ha resums'), 404);
    }

    $data = $resumes->map(function ($resume): array {
        $tagsIds = json_decode($resume->tags_ids, true);

        $randomNumber = rand(1, 3);

        $tags = Tag::whereIn('id', $tagsIds)->get(['id', 'tag_name']);
        $mappedTags = $tags->map(function ($tag) {
            return ['id' => $tag->id, 'name' => $tag->tag_name];
        });

        return [
            'fullname' => $resume->student->name . " " . $resume->student->surname,
            'subtitle' => $resume->subtitle,
            'photo' => asset('/img/stud_' . $randomNumber . '.png'),
            'tags' => $mappedTags,
        ];
    });

    return $data->toArray();
}
}
