<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Service\Tag\TagListService;
use Illuminate\Http\JsonResponse;

class TagListController extends Controller
{
    private TagListService $tagListService;

    public function __construct(TagListService $tagListService)
    {
        $this->tagListService = $tagListService;
    }
    
    public function __invoke(): JsonResponse
    {

        $tagsArray = $this->tagListService->execute();

        $tagsResource = TagResource::collection(collect($tagsArray)->map(function ($tag) {
            return (object) $tag; 
        }));

        return $tagsResource->response();
    }
}
