<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagCollection;
use App\Service\Tag\TagListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class TagListController extends Controller
{
    private TagListService $tagListService;

    public function __construct(TagListService $tagListService)
    {
        $this->tagListService = $tagListService;
    }
    
    public function __invoke(): JsonResponse
    {
        $tags = collect($this->tagListService->execute())->map(fn($tag) => (object) $tag);
        return (new TagCollection($tags))->response()->setStatusCode(200);
    }
}
