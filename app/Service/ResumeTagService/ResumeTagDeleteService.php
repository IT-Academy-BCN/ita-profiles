<?php

namespace App\Service\ResumeTagService;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResumeTagDeleteService
{
    public function removespecifiedTags(array $tagsIds = null): void
    {
        if ($tagsIds === null || count($tagsIds) === 0) {
            throw new BadRequestException(__('No s\'han proporcionat ids'), 400);
        }
        $resume = Auth::user()->student->resume;
        $resume->tags_ids = array_filter(json_decode($resume->tags_ids, true), function ($tagId) use ($tagsIds) {
            return ! in_array($tagId, $tagsIds);
        });
        $resume->save();

    }

    public function removeAllTags(): void
    {
        $resume = Auth::user()->student->resume;
        $resume->tags_ids = [];
        $resume->save();
    }
}
