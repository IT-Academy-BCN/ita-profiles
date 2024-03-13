<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Resume;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class StudentListService
{

    public function execute(?array $specializations = null): array
    {
        $resumes = $this->getResumes($specializations);

        return $this->mapResumesToData($resumes);
    }

    private function getResumes(?array $specializations): Collection
    {

        if ($specializations[0] != null) {
            $resumes = Resume::whereIn('specialization', $specializations)->get();
        } else {
            $resumes = Resume::all();
        }

        if ($resumes->isEmpty()) {
            throw new ModelNotFoundException(__('No hi ha resums'), 404);
        }

        return $resumes;
    }

    private function mapResumesToData(Collection $resumes): array
    {
        return $resumes->map(function ($resume): array {
            return $this->mapResumeToData($resume);
        })->toArray();
    }

    private function mapResumeToData($resume): array
    {
        return [
            'specialization' => $resume->specialization,
            'fullname' => $resume->student->name . " " . $resume->student->surname,
            'subtitle' => $resume->subtitle,
            'photo' => asset('/img/stud_' . rand(1, 3) . '.png'),
            'tags' => $this->getMappedTags($resume),
        ];
    }

    private function getMappedTags($resume): array
    {
        return Tag::whereIn('id', json_decode($resume->tags_ids, true))
            ->get(['id', 'tag_name'])
            ->map(function ($tag) {
                return ['id' => $tag->id, 'name' => $tag->tag_name];
            })
            ->toArray();
    }
}
