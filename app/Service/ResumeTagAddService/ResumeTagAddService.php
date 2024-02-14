<?php 
namespace App\Service\ResumeTagService;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResumeTagAddService
{
    public function execute(?array $tagIds = null): void
    {
        if($tagIds === null || count($tagIds) === 0) {
            throw new BadRequestException('No s\'han proporcionat etiquetas', 400);
        }
        $resume = Auth::user()->student->resume;

        $existingTagIds = json_decode($resume->tags_ids, true);

        $filteredTagIds = $this->filterExistingTags($tagIds);
    
        $updatedTagIds = array_merge($existingTagIds, $filteredTagIds);
        $resume->tags_ids = json_encode($updatedTagIds);
        $resume->save();
    }

    private function filterExistingTags(array $tagIds): array {
        $resume = Auth::user()->student->resume;
        $existingTagIds = json_decode($resume->tags_ids, true);
    
        $filteredTagIds = array_filter($tagIds, function ($tagId) use ($existingTagIds) {
            return !in_array($tagId, $existingTagIds);
        });
    
        return $filteredTagIds;
    }
}